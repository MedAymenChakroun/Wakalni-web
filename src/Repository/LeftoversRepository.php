<?php

namespace App\Repository;

use App\Entity\Leftovers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Leftovers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Leftovers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Leftovers[]    findAll()
 * @method Leftovers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeftoversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leftovers::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Leftovers $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Leftovers $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findAllWithSearch(?string $term)
    {
        $qb = $this->createQueryBuilder('l');
        if ($term) {
            $qb->andWhere('l.sujet LIKE :term OR l.type LIKE :term OR l.quantite LIKE :term')
                ->setParameter('term', '%' . $term . '%')
            ;
        }
        return $qb
            ->getQuery()
            ->getResult();

    }

    public  function  triedecroissant()
    {
        return $this->createQueryBuilder('leftovers')
            ->orderBy('leftovers.dateexpiration','DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Leftovers[] Returns an array of Leftovers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Leftovers
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
