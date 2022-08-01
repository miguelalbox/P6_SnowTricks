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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FigureController extends AbstractController
{
    //Generer un nom unique pour les fichiers
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
    #[Route('/figures', name: 'all_figure')]
    public function all(FiguresRepository $figuresRepo, MediaRepository $mediaRepo): Response
    {
        $figures = $figuresRepo->findAll();

        $portrait = $mediaRepo->findBy([  'figure' => $figures]);


        //dd($portrait);
        return $this->render('figure/all-figure.html.twig', [
            'figures' => $figures,
            'portraits' => $portrait,
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
        $medias = $mediaRepo->findOneBy(['image' => true]);
        $mediaExist = $mediaRepo->findBy(['figure' => $figure->getId()]);
        if ($mediaExist =! null) {
            $ImgByFigure = $mediaRepo->findBy(['image' => true, 'figure' => $figure->getId()]);
            $VideoByFigure = $mediaRepo->findBy(['image' => false, 'figure' => $figure->getId()]);
            $portrait = $mediaRepo->findOneBy(['main' => true, 'figure' => $figure->getId()]);
        }


        $media = new Media;
        $formImages = $this->createForm(MediaType::class, $media);
        $formImages->handleRequest($request);
        if ($formImages->isSubmitted() && $formImages->isValid()) {

            $img = $request->files->get('media')['url'];
            $figureImgName = $this->generateUniqueFileName() . '.' . $img->guessExtension();


            $img->move(
                $this->getParameter('figures_img_directory'),
                $figureImgName
            );
            $media->setImage(true)
                ->setFigure($figure)
                ->setUrl($figureImgName);

            if ($media->isMain() != false){
                $oldMain = $mediaRepo->findOneBy(['main' => true, 'figure' => $figure->getId()]);
                if ($oldMain){
                    $oldMain->setMain(false);
                }
            }

            $manager->persist($media);
            $manager->flush();

            return $this->redirect($request->getUri());
        }

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

        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

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


        return $this->render('figure/edit-figure.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure,
            'medias' => $medias,
            'mediasImg' => $ImgByFigure,
            'mediasVideo' => $VideoByFigure,
            'formImages' => $formImages->createView(),
            'formVideo' => $videoForm->createView(),
            'portrait' => $portrait,
        ]);
    }
    #[Route('/figures/suprimer/{slug}', name: 'delete_figure')]
    public function delete($slug, EntityManagerInterface $manager, FiguresRepository $figureRepo, MediaRepository $mediaRepo )//: Response
    {
        $figure = $figureRepo->findOneBy(['slug' => $slug]);

        /*$mediaExist = $mediaRepo->findBy(['figure' => $figure->getId()]);
        if ($mediaExist =! null) {
            $ImgByFigure = $mediaRepo->findBy(['figure' => $figure->getId()]);
            //$VideoByFigure = $mediaRepo->findBy(['image' => false, 'figure' => $figure->getId()]);

        }*/

        $manager->remove($figure);
        $manager->flush();

        return $this->redirectToRoute('all_figure');
    }
    #[Route('/figures/suprimer/media/{id}', name: 'delete_media')]
    public function deleteMedia(Media $media, EntityManagerInterface $manager)//: Response
    {
        $slug = $media->getFigure()->getSlug();
        $images = $media->getUrl();
        //Suppression du fichier media
        //on recupere le repertoire
        $nameImg = $this->getParameter('figures_img_directory') . '/' . $images;
        //si elle existe
        if (file_exists($nameImg)){
            //on supprime
            unlink($nameImg);
        }


        $manager->remove($media);
        $manager->flush();


        //return $this->redirect($request->request->get('referer'));
        return $this->redirectToRoute('edit_figure', [
            'slug' => $slug
        ]);
    }

}
