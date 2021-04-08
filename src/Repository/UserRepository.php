<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getSuggestion($id, $limit = 5) {

        return $this->createQueryBuilder('u')
            ->select('u')
            // ->leftJoin('u.abonnements', 'a', 'WITH', 'a.user_issuer = u.id')
            ->setMaxResults($limit)
            ->where('u.id != '.$id.'')
            // ->andWhere('a.user_issuer_id !='.$id.'')
            ->getQuery()
            ->getResult()
        ;

    }

     /**
     * @return array
     * @param int $id utilisateur courant
     * @param int $limit limit de la requête
     */
    public function getSuggestionTest(int $id, int $limit = 5): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                u.id,
                u.avatar,
                u.pseudo,
                a.user_issuer_id,
                a.user_receiver_id
            from user u 
            left join abonnement a on u.id = a.user_receiver_id 
            where u.id != '.$id.'
         and (user_issuer_id != '.$id.' OR user_issuer_id IS NULL )
         group by u.id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
     /**
     * @return array
     * @param int $id Identifiant de l'utilisateur 
     */
    public function getDataUser(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                u.id,
                u.avatar,
                u.pseudo
            from user u 
            where u.id = :id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch();
    }

     /**
     * @return array
     * @param int $id Identifiant de l'utilisateur 
     */
    public function getConversationByUser(int $id): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                    u.id as id_user_issuer,
                    u.pseudo as pseudo_user_issuer,
                    u.avatar as avatar_user_issuer,
                    u2.id as id_user_receiver,
                    u2.pseudo as pseudo_user_receiver,
                    u2.avatar as avatar_user_receiver,
                    mp.contenue,
                    mp.created_at,
                    mp.conversation_id
            FROM message_prive mp
            INNER JOIN user u on (u.id = mp.user_issuer_id)
            INNER JOIN user as u2 on (u2.id = mp.user_receiver_id)
            WHERE user_issuer_id = :id OR user_receiver_id = :id
            group by conversation_id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }






    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
