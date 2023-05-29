<?php

namespace App\Repository;

use App\Entity\FichierDemande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FichierDemande>
 *
 * @method FichierDemande|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichierDemande|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichierDemande[]    findAll()
 * @method FichierDemande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichierDemandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichierDemande::class);
    }

    public function save(FichierDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FichierDemande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
//    public function insert(EntityManagerInterface $em,$d)
//    {
//
//        $sql = 'insert into fichier values ($d) ';
//        $stmt = $em->getConnection()->prepare($sql);
//        $resul = $stmt->executeQuery()->fetchAllAssociative();
//        return $resul;
//    }

//    /**
//     * @return FichierDemande[] Returns an array of FichierDemande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FichierDemande
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
