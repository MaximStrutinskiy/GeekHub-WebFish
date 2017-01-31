<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use MainBundle\Entity\Category;

/**
 * Class CategoryRepository
 *
 * @package MainBundle\Repository
 */
class CategoryRepository extends EntityRepository
{

    public function findAllComments($id)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.post = :idPost')
            ->setParameter('idPost', $id)
        ;
        return $qb->getQuery()->getResult();
    }

}
