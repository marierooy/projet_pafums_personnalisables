<?php

namespace App\Repository;

use App\Entity\ReproducedPerfume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReproducedPerfume>
 *
 * @method ReproducedPerfume|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReproducedPerfume|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReproducedPerfume[]    findAll()
 * @method ReproducedPerfume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReproducedPerfumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReproducedPerfume::class);
    }

    public function save(ReproducedPerfume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReproducedPerfume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReproducedPerfume[] Returns an array of ReproducedPerfume objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReproducedPerfume
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
