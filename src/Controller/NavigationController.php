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
     * @Route("/", name="home")
     */
    public function home(PublicationRepository $PublicationRepo){

        $publication = new Publication();
        $allPublications = $PublicationRepo->getAllPublication();

        // dump($allPublications);
        return $this->render('home/index.html.twig', [
            'allPublications' => $allPublications,
            'title' => "accueil",
        ]);
    }
}
