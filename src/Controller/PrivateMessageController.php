<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConversationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrivateMessageController extends AbstractController
{

    /**
     * @Route("/conversation", name="Conversation")
     */
    public function getConversation(ConversationRepository $conversationRepo, UserRepository $userRepo): Response
    {
        $allconversation = $userRepo->getConversationByUser($this->getUser()->getId());
        
        return $this->render('private_message/index.html.twig', [
            'conversation' => $allconversation,
            'title' => 'Conversation',
        ]);
    }
    
    /**
     * @Route("/getMessagePrive", name="getMessagePrive")
     */
    public function getMessagePrive(ConversationRepository $conversationRepo, NormalizerInterface $normalizer): Response
    {
        $conversation = $conversationRepo->find($_GET["id"]);
        $allMessage= $normalizer->normalize($conversation->getMessagePrives(), null, ['groups' => 'messagePrive:read']); 
        dump($allMessage);
        return $this->json(
            [
                'code' => 200,
                'message' => "Ok",
                'allMessage' => $allMessage,
                'idCurrentUser' => $this->getUser()->getId(),
            ],
            200
        );
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