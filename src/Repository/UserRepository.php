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

     /**
     * @return User[] Returns an array of User objects
     */
    
    public function findMatching(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT IGNORE INTO matching (user_source, user_target) SELECT DISTINCT
                :id AS user_source,
                u.id AS user_target
                FROM users_items ui
                INNER JOIN user u ON u.id = ui.user_id
                WHERE user_id <> :id
                AND item_id IN (SELECT item_id FROM users_items WHERE user_id= :id)';


        $stmt = $conn->prepare($sql);
        $stmt->execute(array('id' => $id));

        $sql = 'SELECT * FROM matching m INNER JOIN user u ON u.id = m.user_target
        WHERE m.user_source = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute(array('id' => $id));

        return $stmt->fetchAllAssociative();
    }
    

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
