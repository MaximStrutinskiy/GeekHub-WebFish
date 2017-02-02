<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Like
 *
 * @package MainBundle\Entity
 * @ORM\Table(name="like")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\LikeRepository")
 **/
class Like {

  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * many user many likes
   *One to one
   */
  protected $user;

  public function __construct() {
    $this->user = new \Doctrine\Common\Collections\ArrayCollection();
  }
}
