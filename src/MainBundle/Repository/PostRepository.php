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
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.category = :idCategory')
            ->andWhere('p.postStatus = :postStatus')
            ->orderBy('p.postDate', 'DESC')
            ->setParameter('idCategory', $idCategory)
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }

    public function findCountPostsWithCategoryResult()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('COUNT (p) AS post_count, c.name, c.id')
            ->where('p.postStatus = :postStatus')
            ->innerJoin('p.category', 'c')
            ->groupBy('c.id')
            ->setParameter('postStatus', true);

        return $qb->getQuery()->getResult();
    }

    public function findAllPostByTagQuery(Tag $idTag)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->join('p.tag', 'idTag')
            ->where('idTag = :idTag')
            ->andWhere('p.postStatus = 1')
            ->orderBy('p.postDate', 'DESC')
            ->setParameter(':idTag', $idTag);

        return $qb->getQuery();
    }
}
