<?php

namespace App\Repository;

use App\Entity\Liste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Liste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liste[]    findAll()
 * @method Liste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liste::class);
    }

    /**
     * @return Liste[] Returns an array of Liste objects
     */
    
    public function selectGroupDate()
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.user = :val')
            ->setParameter('val', $this->getUser())
            ->orderBy('l.date', 'ASC')
            ->groupBy('date')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Liste
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
