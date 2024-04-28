<?php

namespace App\Repository;

use App\Entity\Intervenant;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intervenant>
 *
 * @method Intervenant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervenant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervenant[]    findAll()
 * @method Intervenant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntervenantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervenant::class);
    }

    public function findAllWithMatieresFromUser($user) {
        return $this->createQueryBuilder('i')
            ->where(':userMatieres MEMBER OF i.matieresEnseignees')
            ->setParameter('userMatieres', $user->getClasse()->getMatieres())
            ->getQuery()
            ->getResult();
    }
}
