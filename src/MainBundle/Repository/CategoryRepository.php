<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * Class CategoryRepository
 *
 * @package MainBundle\Repository
 */
class CategoryRepository extends EntityRepository
{
//    /**
//     * @param Category
//     * @return Query
//     */
    public function findRandomCategoryQuery()
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->select('c.name, RAND()')
            ->setMaxResults(1)
        ;
        return $qb->getQuery();
    }
}
