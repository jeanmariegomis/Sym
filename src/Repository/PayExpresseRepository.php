<?php

namespace App\Repository;

use App\Entity\PayExpresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PayExpresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayExpresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayExpresse[]    findAll()
 * @method PayExpresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayExpresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayExpresse::class);
    }

    // /**
    //  * @return PayExpresse[] Returns an array of PayExpresse objects
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
    public function findOneBySomeField($value): ?PayExpresse
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
