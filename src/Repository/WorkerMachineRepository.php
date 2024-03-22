<?php

namespace App\Repository;

use App\Entity\Process;
use App\Entity\WorkerMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkerMachine>
 *
 * @method WorkerMachine|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkerMachine|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkerMachine[]    findAll()
 * @method WorkerMachine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkerMachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkerMachine::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(WorkerMachine $entity, bool $flush = true): void
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
    public function remove(WorkerMachine $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    /**
     * @return array
     */
    public function getAllIndex(): array
    {
        return $this->createQueryBuilder('worker_machine', 'worker_machine.id')
            -> getQuery()
            -> getArrayResult();
    }

    /**
     * @return WorkerMachine[]
     */
    public function sortByTypeInAsc(string $type): array
    {
        if ($type == 'cpu') {
            return $this->createQueryBuilder('w')
                ->orderBy('w.cpuAvailable', 'ASC')
                ->getQuery()
                ->getResult();
        }
        else {
            return $this->createQueryBuilder('w')
                ->orderBy('w.memoryAvailable', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }

    // /**
    //  * @return WorkerMachine[] Returns an array of WorkerMachine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkerMachine
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
