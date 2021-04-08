<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivateMessageController extends AbstractController
{

    /**
     * @Route("/conversation", name="Conversation")
     */
    public function getConversation(UserRepository $userRepo): Response
    {
        $allconversation = $userRepo->getConversationByUser($this->getUser()->getId());
        dump($allconversation);
        return $this->render('private_message/index.html.twig', [
            'conversation' => $allconversation,
            'title' => 'Conversation',
        ]);
    }





    /**
     * @Route("/conversation", name="setConversation")
     */
    public function setConversation(Request $Request,EntityManagerInterface $manager, $id = null ): Response
    {
        // dump($id);
            $conversation = new Conversation(); 
            $conversation->setCreatedAt(new \DateTime())
                         ->setType("privateMessage");
            $manager->persist($conversation);
            $manager->flush();

        return $this->render('private_message/index.html.twig', [
            'title' => 'Conversation',
        ]);
    }
}
