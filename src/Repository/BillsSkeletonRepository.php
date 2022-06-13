<?php

namespace App\Repository;

use App\Entity\BillsSkeleton;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BillsSkeleton>
 *
 * @method BillsSkeleton|null find($id, $lockMode = null, $lockVersion = null)
 * @method BillsSkeleton|null findOneBy(array $criteria, array $orderBy = null)
 * @method BillsSkeleton[]    findAll()
 * @method BillsSkeleton[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillsSkeletonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BillsSkeleton::class);
    }

    public function add(BillsSkeleton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(BillsSkeleton $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BillsSkeleton[] Returns an array of BillsSkeleton objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BillsSkeleton
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
