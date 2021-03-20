<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavigationController extends AbstractController
{
    /**
     * @Route("/navigation", name="navigation")
     */
    public function index(): Response
    {
        return $this->render('navigation/index.html.twig', [
            'controller_name' => 'NavigationController',
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home(PublicationRepository $PublicationRepo){

        $publication = new Publication();
        $allPublications = $PublicationRepo->findAll();

        return $this->render('home/index.html.twig', [
            'allPublications' => $allPublications,
        ]);
    }
}
