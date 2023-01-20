<?php

namespace App\Repository;

use App\Entity\Evasan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evasan>
 *
 * @method Evasan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evasan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evasan[]    findAll()
 * @method Evasan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvasanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evasan::class);
    }

    public function add(Evasan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evasan $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Evasan[] Returns an array of Evasan objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evasan
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByQuestionnaire($id)
    {
        return $this->createQueryBuilder('e')
            ->where('e.questionnaire = :id')->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
            //->getResult();
    }
}