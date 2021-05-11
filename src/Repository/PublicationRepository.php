<?php

namespace App\Repository;

use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }
    public function uploadImagePublication($id, $FILES, $index, $publicationID)
    {
        $arrayReponse = [];
        if ($FILES['size'] > 4000000) {
            $arrayReponse['errors'] = "Taille d'image trop grande";
            return $arrayReponse;
        }
        //var_dump($aFiles[0]["size"][$i]);
        $date = date('YmdHis');

        // on récupére l'extension de l'image
        $extensionImage = explode('image/', $FILES['type']);

        $authorized_extension = ['png', 'JPG', 'jpeg', 'JPEG'];
        // si l'extension de l'image est dans l'array des Ext authorisé, on peut upload
        if (in_array($extensionImage[1], $authorized_extension)) {
            $isOkToupload = 1;
        } else {
            $arrayReponse['errors'] =
                "L'image" .
                $FILES['name'] .
                " n'est pas au bon format";
            return $arrayReponse;
        }

        // on renome l'image
        $filename = $index. $date . '.' . $extensionImage[1];

        // création du systéme de sous dossier

        $path_file = 'publication/' . $id . "/". $publicationID;
        // Vérifier l'existance du dossier
        if (!is_dir($path_file)) {
            if (!mkdir($path_file, 0777, true)) {
                $arrayReponse['errors'] =
                    'Echec lors de la création des répertoires dans ' .
                    $path_file;
                return $arrayReponse;
            }
        }
        $location = $path_file . '/' . $filename;
        // on accorde le droit d'upload sur le server
        chmod($path_file, 0777);

        if ($isOkToupload == 1) {
            try {
                // lance l'exeption si on ne peut déplacer le fichier
                if (
                    !move_uploaded_file($FILES['tmp_name'], $location)
                ) {
                    $arrayReponse['errors'] = 'Le fichier ne peut être uplod';
                    return $arrayReponse;
                }

                $arrayReponse['success'] = $filename;

                return $arrayReponse;
            } catch (Exception $e) {
                $messageError = 'File did not upload: ' . $e->getMessage();
                return $messageError;
            }
        }
    }
  
    /**
     * @return array
     */
    public function getAllPublication($userId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT  ph.image,
                    pb.contenu,
                    pb.id,
                    u.id as user_id,
                    pb.created_at,
                    u.avatar,
                    u.pseudo,
                    COUNT(DISTINCT lp.id) as nbr_like,
                    lp2.user_id as isLikedByUser,
                    COUNT(DISTINCT c.contenue) as NbrComment
            FROM publication pb
            JOIN photo ph on pb.id = ph.publication_id
            JOIN user u on u.id = pb.user_id
            LEFT JOIN commentaire c on pb.id = c.publication_id
            LEFT JOIN like_publication lp on lp.publication_id = pb.id
            LEFT JOIN like_publication lp2 ON lp.user_id = :userId
            GROUP BY pb.id
            ORDER BY pb.created_at DESC
            ';
        $stmt = $conn->prepare($sql);

        $stmt->execute(['userId' => $userId]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }
    /**
     * @return array
     */
    public function getPublicationByKey(String $key, Mixed $value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT  ph.image,
                    pb.contenu,
                    pb.id,
                    u.id as user_id,
                    u.avatar,
                    u.pseudo,
                    COUNT(lp.id) as nbr_like,
                    COUNT(c.contenue) as NbrComment
            FROM publication pb
            JOIN photo ph on pb.id = ph.publication_id
            JOIN user u on u.id = pb.user_id
            LEFT JOIN commentaire c on pb.id = c.publication_id
            LEFT JOIN like_publication lp on lp.publication_id = pb.id
            WHERE '.$key.' = '.$value.'
            GROUP BY pb.id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    /**
     * @return array
     * @param String $entity nom de la table
     * @param String $key nom de la colonne
     * @param mixed $value valeur de la colonne 
     */
    public function getNbrEntity(string $entity, string $key, mixed $value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                    COUNT(id) as nbrElement
            FROM '.$entity.'
            WHERE '.$key.' = '.$value.'
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

}

    // /**
    //  * @return Publication[] Returns an array of Publication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
/*
    public function findOneBySomeField($value): ?Publication
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
*/