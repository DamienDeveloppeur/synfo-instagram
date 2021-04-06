<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Photo;
use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Entity\LikePublication;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use App\Repository\LikePublicationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublicationController extends AbstractController
{

    // TO /HOME

    /**
     * @Route("/", name="home")
     */
    public function home(PublicationRepository $PublicationRepo, UserRepository $userRepo){

        $user = new User();
        $publication = new Publication();
        $allPublications = $PublicationRepo->getAllPublication($this->getUser()->getId());
        // dump($userRepo->getSuggestion($this->getUser()->getId()));
        dump( $userRepo->getSuggestion($this->getUser()->getId()));
        return $this->render('home/index.html.twig', [
            'allPublications' => $allPublications,
            "suggestions" => $userRepo->getSuggestion($this->getUser()->getId()),
            'title' => "accueil",
        ]);
    }



    /**
     * @Route("/publication", name="post_publication")
     */
    public function index(Request $Request,EntityManagerInterface $manager, PublicationRepository $repoPubli): Response {
        $publication = new Publication();
        $publication->setUser($this->getuser())
                    ->setCreatedAt(new \DateTime())
                    ->setContenu($_POST["contenue"])
                    ->persist($publication)
                    ->flush();
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

    /**
     * @Route("/postComment", name="postComment")
     */
    public function postComment(Request $Request,EntityManagerInterface $manager, PublicationRepository $publiRepo): Response{
        // $publication = new Publication();
        $idPubli =  $publiRepo->find($_POST["idPublication"]);
        $comment = new Commentaire();

        $comment->setContenue($_POST["contenue"]); 
        $comment->setCreatedAt(new \DateTime());
        $comment->setUser($this->getuser());
        $comment->setPublication($idPubli);
        $manager->persist($comment);
        $manager->flush();
        return $this->json(
            [
                'code' => 200,
                'message' => "Ok",
            ],
            200
        );
    }

    /**
     * @Route("/getComment", name="getComment")
     */
    public function getComment(Request $Request,EntityManagerInterface $manager, CommentaireRepository $commentRepo, PublicationRepository $publiRepo): Response{
        $comment =  $commentRepo->getCommentByPublication($_POST["idPubli"]);
        $onePublication = $publiRepo->getPublicationByKey("pb.id",$_POST["idPubli"]);

        return $this->json(
            [
                'code' => 200,
                'message' => "Ok",
                "comment" => $comment,
                "onePublication" => $onePublication,
                "pathFiles" => $this->getParameter('app.path_publication')
            ],
            200
        );
    }
    /**
     * @Route("/postLike", name="postLike")
     */
    public function postLike(PublicationRepository $publiRepo, LikePublicationRepository $likeRepo, Request $Request,EntityManagerInterface $manager) {

        $user = $this->getUser();
        if (!$user) return $this->json(['code' => 403], 403);
        dump($_POST["publication"]);
        $publication = $publiRepo->find($_POST["publication"]);
        $LP = new LikePublication();

        if($publication->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'publication' => $publication,
                'user' => $user
            ]);
            $manager->remove($like);
            $manager->flush();
            $message = "delete";
        } else {
            $LP->setUser($user);
            $LP->setPublication($publication);
            $manager->persist($LP);
            $manager->flush();
            $message = "add";
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
