<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publication", name="post_publication")
     */
    public function index(Request $Request,EntityManagerInterface $manager,UserRepository $repoUser, PublicationRepository $repoPubli): Response {
        $publication = new Publication();
        $photo = new Photo();

        $pseudal = $this->getuser();
        $publication->setUser($pseudal);

        $dataProfil = $repoUser->find($this->getUser()->getId());

        $publication->setCreatedAt(new \DateTime());
        $publication->setContenu($_POST["contenue"]);
        $manager->persist($publication);
        $manager->flush();

        foreach($_FILES as $file) {
            $ifOk = $repoPubli->uploadImagePublication($this->getUser()->getId(), $file);
            if (!empty($ifOk['success'])) {
                $photo->setImage($ifOk['success']);
                $publicationId = $publication->getId();
                $photo->setPublication($publication);
                $manager->persist($photo);
                $manager->flush();
            } else {
                return $this->json(
                    [
                        'code' => 200,
                        'message' => "Une erreur est survenue",
                    ],
                    200
                );
            }
        }

        return $this->json(
            [
                'code' => 200,
                'message' => "ok",
            ],
            200
        );
        
    }
}
