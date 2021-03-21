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
        $publication->setUser($this->getuser());
        $publication->setCreatedAt(new \DateTime());
        $publication->setContenu($_POST["contenue"]);
        $manager->persist($publication);
        $manager->flush();
        $publicationID = $publication->getId();
        foreach($_FILES as $i => $file) {
            $ifOk = $repoPubli->uploadImagePublication($this->getUser()->getId(), $file, $i, $publicationID);
            if (!empty($ifOk['success'])) {
                $photo = new Photo();
                $photo->setImage($ifOk['success']);
                $photo->setPublication($publication);
                $manager->persist($photo);
                
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
        $manager->flush();

        return $this->json(
            [
                'code' => 200,
                'message' => "ok",
            ],
            200
        );
        
    }
}
