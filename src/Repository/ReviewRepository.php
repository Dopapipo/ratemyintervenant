<?php

namespace App\Repository;

use App\Entity\Intervenant;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Review>
 *
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }
    public function findAllSortedByDate(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //The next 2 are stubs we'll use to implement filtering on reviews later
    //(before we deploy)
    public function findReviewsByIntervenant(Intervenant $intervenant): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.intervenant = :intervenant')
            ->setParameter('intervenant', $intervenant)
            ->orderBy('r.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
    public function findAllSortedByLikes(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.likes', 'DESC')
            ->getQuery()
            ->getResult();
    }




}
