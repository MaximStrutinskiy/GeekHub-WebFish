<?php

namespace MainBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Traits\Repository\ORM\NestedTreeRepositoryTrait;
use Doctrine\ORM\Mapping\ClassMetadata;
/**
 * Class CommentRepository
 *
 * @package MainBundle\Repository
 */
class CommentRepository extends EntityRepository
{

  use NestedTreeRepositoryTrait; // or MaterializedPathRepositoryTrait or ClosureTreeRepositoryTrait.

  public function __construct(EntityManager $em, ClassMetadata $class) {
    parent::__construct($em, $class);

    $this->initializeTreeRepository($em, $class);
  }

  public function findAllComments($id) {
    $qb = $this->createQueryBuilder('c');
    $qb
      ->where('c.post = :idPost')
      ->setParameter('idPost', $id);
    return $qb->getQuery()->getResult();
  }
}
