<?php

namespace App\Controller;

use App\Entity\Figures;
use App\Form\FigureType;
use App\Repository\FiguresRepository;
use App\Repository\GroupsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FigureController extends AbstractController
{
    #[Route('/figures', name: 'all_figure')]
    public function all(): Response
    {
        return $this->render('figure/all-figure.html.twig', [
            
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
        return $this->render('figure/add-edit-figure.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/figures/editer/{slug}', name: 'edit_figure')]
    public function edit(): Response
    {
        return $this->render('figure/add-edit-figure.html.twig', [
            
        ]);
    }
    #[Route('/figures/suprimer', name: 'delete_figure')]
    public function delete()//: Response
    {
       /* return $this->render('figure/add-edit-figure.html.twig', [
            
        ]);*/
    }
}
