<?php

namespace App\Repository;

use App\Entity\LikePublication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LikePublication|null find($id, $lockMode = null, $lockVersion = null)
 * @method LikePublication|null findOneBy(array $criteria, array $orderBy = null)
 * @method LikePublication[]    findAll()
 * @method LikePublication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikePublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LikePublication::class);
    }

    // /**
    //  * @return LikePublication[] Returns an array of LikePublication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LikePublication
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
