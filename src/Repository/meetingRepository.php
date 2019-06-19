<?php

namespace App\Repository;

use App\Entity\meeting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method meeting|null find($id, $lockMode = null, $lockVersion = null)
 * @method meeting|null findOneBy(array $criteria, array $orderBy = null)
 * @method meeting[]    findAll()
 * @method meeting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class meetingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, meeting::class);
    }

    // /**
    //  * @return meeting[] Returns an array of meeting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?meeting
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
