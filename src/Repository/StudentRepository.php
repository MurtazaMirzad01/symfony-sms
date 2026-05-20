<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function search(
        ?string $query,
    ): array
    {
        $qb = $this->createQueryBuilder('s');
        if ($query) {
            $qb->andWhere( 's.name LIKE :query
                 OR s.email LIKE :query')
                ->setParameter('query', '%' . $query . '%');
        }
        return $qb->orderBy(
            's.createdAt',
            'DESC'
        )->getquery()
            ->getResult();
    }

    public function searchQuery(
        ?string $query = null,
    ):QueryBuilder
    {
        $qb= $this->createQueryBuilder('s');

        if ($query) {

            $qb
                ->andWhere(
                    '
                LOWER(s.name)
                LIKE :query

                OR LOWER(s.email)
                LIKE :query
                '
                )

                ->setParameter(
                    'query',
                    '%'
                    .
                    mb_strtolower(
                        $query
                    )
                    .
                    '%'
                );
        }

        return $qb
            ->orderBy('s.createdAt', 'DESC');
    }


//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
