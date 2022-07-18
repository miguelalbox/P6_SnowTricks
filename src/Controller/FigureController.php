<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Entity\Media;
use App\Form\FigureType;
use App\Form\MediaType;
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
    public function edit( FiguresRepository $figureRepo, $slug, Request $request, EntityManagerInterface $manager): Response
    {
    $figure = $figureRepo->findOneBy(['slug' => $slug]);

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
        }

    $media = new Media;
    $form2 = $this->createForm(MediaType::class, $media);
    $form2->handleRequest($request);
        /*TODO if ($form2->isSubmitted() && $form2->isValid()) {
        }*/

        return $this->render('figure/edit-figure.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure,
            'form2' => $form2->createView(),
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
}
