<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Abonnement;
use Psr\Log\LoggerInterface;
use App\Repository\UserRepository;
use App\Repository\AbonnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbonnementController extends AbstractController
{

    /**
     * @Route("/post_abonnement", name="post_abonnement")
     */
    public function setAbonnement(Request $Request,EntityManagerInterface $manager, UserRepository $userRepo, AbonnementRepository $aboRepo): Response
    {
        // $userReceiver = new User();

        $userReceiver = $userRepo->find($_POST["idUser"]);
        dump($userReceiver);

        $ifAlreadyAbo = $aboRepo->findOneBy([
            'user_receiver' => $userReceiver,
            'user_issuer' => $this->getUser()
        ]);
        dump($ifAlreadyAbo);
        if(empty($ifAlreadyAbo)) {
            $abonnement = new Abonnement();
            $abonnement->setUserReceiver($userReceiver)
                        ->setUserIssuer($this->getUser())
                        ->setCreatedAt(new \DateTime());
            $manager->persist($abonnement);
            $manager->flush();
            $message="ok";
        }else {
            $message="not";
        }
      
        return $this->json(
            [
                'code' => 200,
                'message' => $message,
            ],
            200
        );
    }





}
