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
     * @Route("/profil/{id}", name="profil")
     */
    public function index($id, PublicationRepository $repoPubli, UserRepository $repoUser): Response {
        dump($id);
        // $user = $repoUser->find($id);
        $allPublications = $repoPubli->getPublicationByKey(
            'pb.user_id',
            $id
        );
        $dataUser = $repoUser->getDataUser($id);
        // équivalent de $_SESSION["utilisateur_id"]
        // $userId = $user->getId();

        $nbrPubli = $repoPubli->getNbrEntity(
            'publication',
            'user_id',
            $id
        );
        dump($nbrPubli);
        return $this->render('profil/index.html.twig', [
            'allPublications' => $allPublications,
            'userId' => $id,
            'nbrPubli' => $nbrPubli,
            'dataUser' => $dataUser,
            'title' => 'Mon profil',
        ]);
    }


}
