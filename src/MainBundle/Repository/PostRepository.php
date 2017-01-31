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

  public function findCountPostsWithCategory() {

    $qb = $this->createQueryBuilder('p');
    $qb
      ->select('COUNT (p) AS post_count, c.name')
//      ->where('p.postStatus = 1')
      ->join('p.category', 'c.name')
      ->groupBy('c.id');
    return (int) $qb->getQuery()->getResult();
  }

->createQueryBuilder()
->addSelect('category')
->from('AcmeVideoBundle:Video', 'video')
->leftJoin('video.category', 'category')
->groupBy('category.id')
->having('COUNT(video.id) > 1000')
->orderBy('category.name', 'ASC')
->getQuery();
//  public function findCountForCategories() {
//    return (int) $this->createQueryBuilder('n')
//      ->select('COUNT AS articles_count, c.slug')
//      ->join('n.category', 'c')
//      ->groupBy('c.id')
//      ->getQuery()
//      ->getResult();
//      }
//      [['slug' => 'category-name', 'articles_count' => 25]
SELECT f FROM EMMyFriendsBundle:Friend f WHERE f.name = " '.$param ' "
SELECT f FROM EMMyFriendsBundle:Friend f WHERE f.name = " '.$param ' "


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
