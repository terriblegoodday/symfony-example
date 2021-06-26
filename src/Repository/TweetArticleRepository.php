<?php

namespace App\Repository;

use App\Entity\TweetArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TweetArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method TweetArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method TweetArticle[]    findAll()
 * @method TweetArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TweetArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TweetArticle::class);
    }

    // /**
    //  * @return TweetArticle[] Returns an array of TweetArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TweetArticle
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
