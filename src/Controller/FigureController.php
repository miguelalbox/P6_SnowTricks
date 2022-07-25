<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Entity\Media;
use App\Form\FigureType;
use App\Form\MediaType;
use App\Form\VideoType;
use App\Repository\FiguresRepository;
use App\Repository\GroupsRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FigureController extends AbstractController
{
    #[Route('/figures', name: 'all_figure')]
    public function all(FiguresRepository $figuresRepo): Response
    {
        $figures = $figuresRepo->findAll();
        return $this->render('figure/all-figure.html.twig', [
            'figures' => $figures,
        ]);
    }

    #[Route('/figures/figure/{id}', name: 'single_figure')]
    public function single(): Response
    {
        return $this->render('figure/single-figure.html.twig', [
            
        ]);
    }

    #[Route('/figures/ajouter', name: 'add_figure')]
    public function add(Request $request, EntityManagerInterface $manager, FiguresRepository $figureRepo, GroupsRepository $groupsRepo): Response
    {
        $figure = new Figures;


        $groups = $groupsRepo->findAll();
        $groupsFigure = [];

        foreach ($groups as $group){
            $groupsFigure[$group->getFigureGroup()] = $group->getFigureGroup();
        }
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $title = $figure->getTitle();
            $slugger = new AsciiSlugger();
            $slug = strtolower($slugger->slug($title, '-'));
            $i = 0;

            do {
                $existSlug = $figureRepo->findOneBy([
                    'slug' => $slug
                ]);
                if ($existSlug != null) {
                    $slug = strtolower($slugger->slug($title, '-') .'-'. $i);
                    $i++;
                }
            } while ($existSlug != null);
            $figure->setSlug($slug);

            $figure->setCreatedAt(new \DateTimeImmutable());

            //ajout de media
            /*$media = $form->get('Media')->getData();
            foreach ($medias as $media){
                new Media
            }*/


            $manager->persist($figure);
            $manager->flush();
            $this->addFlash("success", "La figure a bien été ajouté" );

            return $this->redirectToRoute('all_figure');
        }
        return $this->render('figure/add-figure.html.twig', [
            'form' => $form->createView(),

        ]);
    }
    #[Route('/figures/editer/{slug}', name: 'edit_figure')]
    public function edit( FiguresRepository $figureRepo, MediaRepository $mediaRepo, $slug, Request $request, EntityManagerInterface $manager): Response
    {
    $figure = $figureRepo->findOneBy(['slug' => $slug]);

    $form = $this->createForm(FigureType::class, $figure);
    $form->handleRequest($request);

        $video = new Media();
        $videoForm = $this->createForm(VideoType::class, $video);
        $videoForm->handleRequest($request);

        if ($videoForm->isSubmitted() && $videoForm->isValid())
        {
            // TODO: save video
            $video->setImage(false)
                ->setFigure($figure)
                ->setMain(false);

            $manager->persist($video);
            $manager->flush();

            return $this->redirect($request->getUri());
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $title = $figure->getTitle();
            $slugger = new AsciiSlugger();
            $slug = strtolower($slugger->slug($title, '-'));
            $i = 0;

            do {
                $existSlug = $figureRepo->findOneBy([
                    'slug' => $slug
                ]);
                if ($existSlug != null) {
                    $slug = strtolower($slugger->slug($title, '-') . '-' . $i);
                    $i++;
                }
            } while ($existSlug != null);
            $figure->setSlug($slug);

            $figure->setUpdatedAt(new \DateTime());
            $manager->persist($figure);
            $manager->flush();

            return $this->redirectToRoute('all_figure');
        }
        //$figures = $figure->getId();
        //dd($figures);

    $media = new Media;
        $formImages = $this->createForm(MediaType::class, $media);
        $formImages->handleRequest($request);
        if ($formImages->isSubmitted() && $formImages->isValid()) {

            $img = $request->files->get('media')['url'];

            /*TODO Modifier la route de fichiers image*/
            $image = $media->getUrl();
            $figureImgName = 'figure-'.$slug . '.' . $img->guessExtension();
            $img->move(
              $this->getParameter('figures_img_directory'),
              $figureImgName
            );
            $media->setImage(true)
                    ->setFigure($figure)
                    ->setUrl($figureImgName);

            if ($media->isMain() != false){
                $oldMain = $mediaRepo->findOneBy(['main' => true]);
                if ($oldMain){
                    $oldMain->setMain(false);
                }
            }

            $manager->persist($media);
            $manager->flush();
        }



       /*$formVideos = $this->createForm(MediaType::class, $media);
        $formVideos->handleRequest($request);
        if ($formVideos->isSubmitted() && $formVideos->isValid()) {


            $formVideo = $request->request->get("url");

            $media->setImage(false);
            $media->setUrl($formVideo);
            $media->setFigure($figure);

            $manager->persist($media);
            $manager->flush();
        }*/


        return $this->render('figure/edit-figure.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure,
            'formImages' => $formImages->createView(),
            'formVideo' => $videoForm->createView(),
            //'$formVideos' => $formVideos->createView(),
        ]);
    }
    #[Route('/figures/suprimer/{slug}', name: 'delete_figure')]
    public function delete($slug, EntityManagerInterface $manager, FiguresRepository $figureRepo )//: Response
    {
        $figure = $figureRepo->findOneBy(['slug' => $slug]);
        $manager->remove($figure);
        $manager->flush();

        return $this->redirectToRoute('all_figure');
       /* return $this->render('figure/add-figure.html.twig', [
            
        ]);*/
    }

    #[Route('/img-directory', name: 'media_img_directory')]
    public function mediaImg(): Response
    {
        return $this->render('');
    }

}
