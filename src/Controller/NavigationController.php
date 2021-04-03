<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Publication;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavigationController extends AbstractController
{

  /**
     * @Route("/get_all_suggestion", name="get_all_suggestion")
     */
    public function getAllSuggestion(Request $Request,EntityManagerInterface $manager, UserRepository $userRepo): Response
    {
        $allSuggestion = $userRepo->getSuggestion($this->getUser()->getId(), 100);
        dump($allSuggestion);
        return $this->render('home/suggestion.html.twig', [
            'allSuggestion'      => $allSuggestion,
            'title'           => "Toutes les suggestions",
        ]);
    }
    
}
