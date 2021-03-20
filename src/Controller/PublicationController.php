<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publication", name="post_publication")
     */
    public function index(Request $Request,EntityManagerInterface $manager,UserRepository $repo): Response {
        $publication = new Publication();

        // $form = $this->createForm(PublicationType::class, $publication);
        // $form->handleRequest($Request);

        $pseudal = $this->getuser();
        $publication->setUser($pseudal);

        $dataProfil = $repo->find($this->getUser()->getId());

        $publication->setCreatedAt(new \DateTime());
        $publication->setContenu($_POST['describ']);

        // nom de l'image
        $ifOk = $publication->uploadImagePublication($this->getUser()->getId());
        if (!empty($ifOk['success'])) {
            $publication->setImage($ifOk['success']);
            $manager->persist($publication);
            $manager->flush();
            return $this->render('profil/index.html.twig');
        }else {
                
        }

        
    }
}
