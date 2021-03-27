<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/* Entity */
use App\Entity\User;
use App\Form\UserType;

/* FORM */
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

/* password Encode*/
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $Request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($Request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $user->getPassword();
            $hash = $encoder->encodePassword($user, $plainPassword);
            $user->setCreatedAt(new \DateTime());
            $user->setUserActif(1);
            $user->setPassword($hash);
            $user->setAvatar("photo_profil.jpg");

            $manager->persist($user);
            $manager->flush();


            return $this->render('security/login.html.twig');
        }

        return $this->render('security/register.html.twig', [
            'formRegister' => $form->createView(),
            'title' => "Inscription",
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
             'error' => $error,
             'title' => "Connexion",
            ]);
    }
}
