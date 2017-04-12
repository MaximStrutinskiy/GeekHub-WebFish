<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use MainBundle\Entity\Like;
use MainBundle\Entity\Tag;

/**
 * Class PostRepository
 *
 * @package MainBundle\Repository
 */
class PostRepository extends EntityRepository
{
    public function findPostsQuery()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.postStatus = :postStatus')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }

    public function findPostsWithCountCommentQuery()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p', 'p, COUNT (c) AS count_post_comments')
            ->where('p.postStatus = :postStatus')
            ->leftJoin('p.postComment', 'c')
            ->groupBy('p.id')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }

    public function findPostsWithCountLikeQuery()
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p', 'p, COUNT (l) AS count_post_like')
            ->where('p.postStatus = :postStatus')
            ->leftJoin('p.postLike', 'l')
            ->groupBy('p.id')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }

    public function findAllPostByCategoryQuery($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p', 'p, COUNT (c) AS count_post_comments')
            ->where('p.category = :idCategory')
            ->andWhere('p.postStatus = :postStatus')
            ->leftJoin('p.postComment', 'c')
            ->groupBy('p.id')
            ->orderBy('p.id', 'DESC')
            ->setParameter('idCategory', $id)
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

    public function findCountPostsWithCommentResult($id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p', 'p, COUNT (c) AS count_post_comments')
            ->where('p.postStatus = :postStatus')
            ->andWhere('p.id = :postId')
            ->leftJoin('p.postComment', 'c')
            ->groupBy('p.id')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true)
            ->setParameter('postId', $id);

        return $qb->getQuery();
    }

    public function findAllPostByTagQuery(Tag $id)
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->select('p', 'p, COUNT (c) AS count_post_comments')
            ->join('p.tag', 'idTag')
            ->leftJoin('p.postComment', 'c')
            ->groupBy('p.id')
            ->where('idTag = :idTag')
            ->setParameter(':idTag', $id)
            ->andWhere('p.postStatus = :postStatus')
            ->orderBy('p.postDate', 'DESC')
            ->setParameter('postStatus', true);

        return $qb->getQuery();
    }

    public function findPostByTitle($search_text){
        $qb = $this->createQueryBuilder('p');

        $qb
            ->select('p')
            ->where('p.shortTitle LIKE :search_text')
            ->andWhere('p.postStatus = :postStatus')
            ->orderBy('p.id', 'DESC')
            ->setParameter('postStatus', true)
            ->setParameter('search_text', '%'.$search_text.'%');

        return $qb->getQuery();
    }
}
