<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use MainBundle\Entity\Tag;

/**
 * Class PostRepository
 *
 * @package MainBundle\Repository
 */
class PostRepository extends EntityRepository
{
    public function findAllPostsQuery()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.postStatus = 1')
            ->orderBy('p.postDate', 'DESC');

        return $qb->getQuery();
    }


    public function findAllPostByCategoryQuery($idCategory)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->where('a.category = :idCategory')
            ->orderBy('a.postDate', 'DESC')
            ->setParameter('idCategory', $idCategory);

        return $qb->getQuery();
    }

    public function findAllPostByTagQuery(Tag $idTag)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->join('a.tag', 't')
            ->where('t = :idTag')
            ->orderBy('a.postDate', 'DESC')
            ->setParameter(':idTag', $idTag)
        ;
        return $qb->getQuery();
    }
}
