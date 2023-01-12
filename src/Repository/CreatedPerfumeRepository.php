<?php

namespace App\Repository;

use App\Entity\CreatedPerfume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreatedPerfume>
 *
 * @method CreatedPerfume|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreatedPerfume|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreatedPerfume[]    findAll()
 * @method CreatedPerfume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreatedPerfumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreatedPerfume::class);
    }

    public function save(CreatedPerfume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CreatedPerfume $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CreatedPerfume[] Returns an array of CreatedPerfume objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CreatedPerfume
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
