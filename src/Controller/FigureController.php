<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    #[Route('/figures', name: 'all_figure')]
    public function all(): Response
    {
        return $this->render('figure/all-figure.html.twig', [
            
        ]);
    }

    #[Route('/figure/{id}', name: 'single_figure')]
    public function single(): Response
    {
        return $this->render('figure/single-figure.html.twig', [
            
        ]);
    }

    #[Route('/ajouter-figure', name: 'add_figure')]
    public function add(): Response
    {
        return $this->render('figure/add-edit-figure.html.twig', [
            
        ]);
    }
    #[Route('/editer-figure/{slug}', name: 'edit_figure')]
    public function edit(): Response
    {
        return $this->render('figure/add-edit-figure.html.twig', [
            
        ]);
    }
    #[Route('/suprimer-figure', name: 'delete_figure')]
    public function delete()//: Response
    {
       /* return $this->render('figure/add-edit-figure.html.twig', [
            
        ]);*/
    }
}
