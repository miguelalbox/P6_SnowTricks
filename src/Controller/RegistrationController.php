<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
   /* protected $mailer;
    public function __construct(MailerInterface $mailer)
    {
    $this->mailer = $mailer;
    }*/

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, MailerInterface $mailer, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            //TODO setToken provisoire
            $user->setToken('test');
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setActivated(false);

            $token = bin2hex(random_bytes(16));

            $user->setToken($token);

            $entityManager->persist($user);
            $entityManager->flush();

            $mail = (new Email())
                  ->from("contact@snowtricks.com")
                  ->to($user->getEmail())
                  ->text("Voici votre lien de verification de mail https://127.0.0.1:8001/activate/" . $token)
                  ->subject("Activation de compte sur SnowTricks pour " . $user->getUserName());
                //TODO chager le url par le path dynamique de url

            $mailer->send($mail);


            // do anything else you need here, like send an email

            /*return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );*/

            return $this->redirectToRoute('all_figure');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/activate/{token}', name: 'activate')]
    public function activate($token, EntityManagerInterface $manager, UserRepository $userRepo): Response
    {
        $user = $userRepo->findOneBy(['token' => $token]);
        if ( $user == null){
            $this->addFlash('error', 'Votre compte est deja activé');
            return $this->redirectToRoute('homepage');
        }

        $user->setActivated('1');
        $user->setToken('');
//TODO je n'arrive pas a metre le setToken en null

        $manager->persist($user);
        $manager->flush();
        $this->addFlash('success', 'Votre compte est activé');


        return $this->redirectToRoute('homepage');
    }

}
