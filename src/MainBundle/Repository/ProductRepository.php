<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ProductRepository
 *
 * @package MainBundle\Repository
 */
class ProductRepository extends EntityRepository
{
    public function findProductsQuery()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.postStatus = :postStatus')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }
}
