<?php

namespace App\Repository;

use App\Entity\TaxesPercentage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaxesPercentage>
 *
 * @method TaxesPercentage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaxesPercentage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaxesPercentage[]    findAll()
 * @method TaxesPercentage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaxesPercentageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaxesPercentage::class);
    }

    public function add(TaxesPercentage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TaxesPercentage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TaxesPercentage[] Returns an array of TaxesPercentage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaxesPercentage
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
