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
class PostRepository extends EntityRepository {
  public function findAllPostsQuery() {
    $qb = $this->createQueryBuilder('p');
    $qb
      ->where('p.postStatus = 1')
      ->orderBy('p.postDate', 'DESC');

    return $qb->getQuery();
  }

  public function findAllPostByCategoryQuery($idCategory) {
    $qb = $this->createQueryBuilder('p');
    $qb
      ->where('p.category = :idCategory')
      ->andWhere('p.postStatus = 1')
      ->orderBy('p.postDate', 'DESC')
      ->setParameter('idCategory', $idCategory);

    return $qb->getQuery();
  }

  public function findCountPostsWithCategory($id) {

    $qb = $this->createQueryBuilder('p');
    $qb
      ->where('p.category = :idCategory')
      ->andWhere('p.postStatus = 1')
      ->setParameter('idCategory', $id)
      ->select('COUNT(p) AS postCount')
    ;
    return $qb->getQuery()->getResult();
  }

  public function findAllPostByTagQuery(Tag $idTag) {
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
