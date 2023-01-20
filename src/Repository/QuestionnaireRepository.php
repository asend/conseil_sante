<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questionnaire>
 *
 * @method Questionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questionnaire[]    findAll()
 * @method Questionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }

    public function add(Questionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Questionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Questionnaire[] Returns an array of Questionnaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Questionnaire
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByPatientAndConseil($idC, $idP)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.conseil = :idC')->setParameter('idC', $idC)
            ->andWhere('q.patient = :idP')->setParameter('idP', $idP)
            ->getQuery()
            ->getOneOrNullResult();
            //->getResult();
    }

    public function otherQuestion($idC, $idP){
        return $this->createQueryBuilder('q')
            ->andWhere('q.conseil != :idC')->setParameter('idC', $idC)
            ->andWhere('q.patient = :idP')->setParameter('idP', $idP)
            ->getQuery()
            ->getResult();
    }

    public function findByCertificat($idCertificat){
        return $this->createQueryBuilder('q')
        ->andWhere('q.certificat = :idC')
        ->setParameter('idC', $idCertificat)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findByConseilWithDecision($idC){
        return $this->createQueryBuilder('q')
            ->andWhere('q.conseil = :idC')->setParameter('idC', $idC)
            ->andWhere('q.decision_conseil is not null')
            ->getQuery()
            ->getResult();
    }
}