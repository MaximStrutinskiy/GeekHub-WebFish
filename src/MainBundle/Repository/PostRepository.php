<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;

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
}
