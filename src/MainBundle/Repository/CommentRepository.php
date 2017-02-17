<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityRepository;
/**
 * Class CommentRepository
 *
 * @package MainBundle\Repository
 */
class CommentRepository extends EntityRepository
{

  public function findAllComments($id) {
    $qb = $this->createQueryBuilder('c');
    $qb
      ->where('c.post = :idPost')
      ->setParameter('idPost', $id);
    return $qb->getQuery()->getResult();
  }
}
