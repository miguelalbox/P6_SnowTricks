<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Figures;
use App\Entity\Groups;
use App\Entity\Media;
use App\Form\CommentType;
use App\Form\FigureType;
use App\Form\MediaType;
use App\Form\VideoType;
use App\Repository\CommentsRepository;
use App\Repository\FiguresRepository;
use App\Repository\GroupsRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
    #[Route('/', name: 'all_figure')]
    public function all(FiguresRepository $figuresRepo, MediaRepository $mediaRepo, PaginatorInterface $paginator, Request $request): Response
    {
        if ($this->getUser()){
            $user = $this->getUser()->getId();
            $figuresUser = $figuresRepo->findby(['user' => $user]);
        }
        else{
            $user = null;
            $figuresUser = null;
        }
        $figures = $figuresRepo->findAll();


        $figuresAll = $paginator->paginate(
            $figures, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            9 // Nombre de résultats par page
        );

        $portrait = $mediaRepo->findBy([  'figure' => $figures]);

        return $this->render('figure/all-figure.html.twig', [
            'figures' => $figuresAll,
            'portraits' => $portrait,
            'user' => $user,
            'figuresUser' => $figuresUser,
        ]);
    }
    #[Route('/mes-figures', name: 'all_figure_user')]
    public function allFiguresUser(FiguresRepository $figuresRepo, MediaRepository $mediaRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $figures = $figuresRepo->findby(['user' => $user]);

        $figuresAll = $paginator->paginate(
            $figures, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            9// Nombre de résultats par page
        );

        $portrait = $mediaRepo->findBy([  'figure' => $figures]);

        return $this->render('figure/all-figure-user.html.twig', [
            'figures' => $figuresAll,
            'portraits' => $portrait,
        ]);
    }

    #[Route('/figure/{id}', name: 'single_figure')]
    public function single(Figures $figures, PaginatorInterface $paginator, MediaRepository $mediaRepo,FiguresRepository $figuresRepo, GroupsRepository $groupsRepo, $id, Request $request, EntityManagerInterface $manager, CommentsRepository $commentsRepo): Response
    {
        $groups = $groupsRepo->findAll();
        $figureGroup = $figuresRepo->findOneBy(['id' => $id]);
//dd($figureGroup->getGroups()->getFigureGroup());
        $figure = $figures;
        $figureComments = $commentsRepo->findBy(['figureId' => $id,]);
        //dd($figureComments);
        $figureCommentsPaginator = $paginator->paginate(
            $figureComments, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1,), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page

        );

        if ($this->getUser()){
            $user = $this->getUser()->getId();
            $figuresUser = $figuresRepo->findby(['user' => $user]);
        }
        else{
            $user = null;
            $figuresUser = null;
        }

        $mediaExist = $mediaRepo->findBy(['figure' => $figure->getId()]);
        if ($mediaExist =! null) {
            $ImgByFigure = $mediaRepo->findBy(['image' => true, 'figure' => $figure->getId()]);
            $VideoByFigure = $mediaRepo->findBy(['image' => false, 'figure' => $figure->getId()]);
            $portrait = $mediaRepo->findOneBy(['main' => true, 'figure' => $figure->getId()]);
        }
        //dd($group->getFigureGroup());

        $comment = New Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setUser($this->getUser());
            $comment->setFigureId($figure);

            $manager->persist($comment);
            $manager->flush();
            $this->addFlash("success", "Le commentaire a bien été ajouté" );

            return $this->redirect($request->getUri());
        }


        return $this->render('figure/single-figure.html.twig', [
            'figure' => $figure,
            'mediasImg' => $ImgByFigure,
            'mediasVideo' => $VideoByFigure,
            'portrait' => $portrait,
            'group' => $figureGroup->getGroups()->getFigureGroup(),
            'user' => $user,
            'figuresUser' => $figuresUser,
            'commentForm' => $form->createView(),
            'comments' => $figureCommentsPaginator,
        ]);
    }

    #[Route('/figures/ajouter', name: 'add_figure')]
    public function add(Request $request, EntityManagerInterface $manager, FiguresRepository $figureRepo, GroupsRepository $groupsRepo): Response
    {

        $figure = new Figures;
//ajout d'utilisateur en session
        $user = $this->getUser();
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
            $figure->setUser($user);

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
    public function edit( FiguresRepository $figureRepo, Figures $figure, MediaRepository $mediaRepo, $slug, Request $request, EntityManagerInterface $manager): Response
    {
        $figureUser = $figure->getUser();
        //TODO securite, on ne peut pas acceder si on n'est pas l'utilisateur
        if ($this->getUser() != $figureUser) {
            $this->addFlash('error', 'La figure ne vous partien pas');
            return $this->redirectToRoute('all_figure');
        }

            $imgByFigure = $mediaRepo->findBy(['image' => true, 'figure' => $figure->getId()]);
            $videoByFigure = $mediaRepo->findBy(['image' => false, 'figure' => $figure->getId()]);
            $portrait = $mediaRepo->findOneBy(['main' => true, 'figure' => $figure->getId()]);


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

            if ($media->isMain() != false) {
                $oldMain = $mediaRepo->findOneBy(['main' => true, 'figure' => $figure->getId()]);
                if ($oldMain) {
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

        if ($videoForm->isSubmitted() && $videoForm->isValid()) {
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
            'mediasImg' => $imgByFigure,
            'mediasVideo' => $videoByFigure,
            'formImages' => $formImages->createView(),
            'formVideo' => $videoForm->createView(),
            'portrait' => $portrait,
        ]);
    }
    #[Route('/figures/suprimer/{slug}', name: 'delete_figure')]
    public function delete($slug, EntityManagerInterface $manager, FiguresRepository $figureRepo, Figures $figure, MediaRepository $mediaRepo)//: Response
    {
        $figureUser = $figure->getUser();
        //TODO securite, on ne peut pas acceder si on n'est pas l'utilisateur
        if ($this->getUser() != $figureUser) {
            $this->addFlash('error', 'La figure ne vous partien pas');
            return $this->redirectToRoute('all_figure');
        }

        $figures = $figureRepo->findOneBy(['slug' => $slug]);

        $mediasFigures = $mediaRepo->findBy(['figure' => $figure->getId()]);
        //TODO suprimer image en cascade je recupere les images de la figure puis pour chaque une des entite je suprime le fichier avec un boucle for avec unlink

        //TODO il suprime une seul image pour le moment

        /*$groupsImages = [];

        foreach ($mediasFigures as $mediasFigure){
            $groupsImages[$mediasFigure->getUrl()] = $mediasFigure->getUrl();
        }
        dd($groupsImages);



        /*foreach ($mediasFigures as $mediasFigure) {
            $url = $media->getUrl();
            $nameImg = $this->getParameter('figures_img_directory') . '/' . $url;
            //si elle existe
            //dd($mediasFigure->getUrl());
            if ($mediasFigure->isImage() == true){
                //dd($mediasFigure->isImage());
                if ($mediasFigure->getUrl() == $url) {
                    //dd($mediasFigure->getUrl());
                    unlink($nameImg);
                }
            }

        }

        dd($mediasFigures);*/

            $manager->remove($figure);
            $manager->flush();

            return $this->redirectToRoute('all_figure');

    }
    #[Route('/figures/suprimer/media/{id}', name: 'delete_media')]
    public function deleteMedia(Media $media, EntityManagerInterface $manager)//: Response
    {
        $mediaUser = $media->getFigure()->getUser();
        //TODO securite, on ne peut pas acceder si on n'est pas l'utilisateur
        if ($this->getUser() == $mediaUser) {
            $slug = $media->getFigure()->getSlug();
            $images = $media->getUrl();
            //Suppression du fichier media
            //on recupere le repertoire
            $nameImg = $this->getParameter('figures_img_directory') . '/' . $images;
            //si elle existe
            if (file_exists($nameImg)) {
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
        else{
            //TODO addFlash pour dire que vous ne pouvez pas entrer dans une url de tricks d'autre personne
            $this->addFlash('error', 'Le media ne vous partien pas');
            return $this->redirectToRoute('all_figure');
        }
    }
    #[Route('/figures/suprimer/portrait/{id}', name: 'delete_portrait')]
    public function deletePortrait(Media $media, EntityManagerInterface $manager)//: Response
    {
        $mediaUser = $media->getFigure()->getUser();
        //TODO securite, on ne peut pas acceder si on n'est pas l'utilisateur
        if ($this->getUser() == $mediaUser) {
            $media->setMain(false);
            $slug = $media->getFigure()->getSlug();

            $manager->persist($media);
            $manager->flush();


            //return $this->redirect($request->request->get('referer'));
            return $this->redirectToRoute('edit_figure', [
                'slug' => $slug
            ]);


        } else {
            //TODO addFlash pour dire que vous ne pouvez pas entrer dans une url de tricks d'autre personne
            $this->addFlash('error', 'Le media ne vous partien pas');
            return $this->redirectToRoute('all_figure');
        }
    }
}
