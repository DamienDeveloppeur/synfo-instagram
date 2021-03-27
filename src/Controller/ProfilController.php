<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\UserRepository;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(PublicationRepository $repo, UserInterface  $user ): Response
    {
        $allPublications = $repo->getAllPublicationByKey("pb.user_id",$this->getUser()->getId());
        // équivalent de $_SESSION["utilisateur_id"]
        $userId = $user->getId();

        $nbrPubli =  $repo->getNbrEntity("publication", "user_id",$this->getUser()->getId() );
        dump($nbrPubli);
        return $this->render('profil/index.html.twig', [
            'allPublications' => $allPublications,
            "userId"          => $userId,
            'nbrPubli'        => $nbrPubli,
            'title'           => "Mon profil",
        ]);
    }
}
