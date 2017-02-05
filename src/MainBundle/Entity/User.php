<?php

namespace MainBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\UserRepository")
 */
class User extends BaseUser {
  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   *
   * @Assert\Length(
   *     min=3,
   *     max=255,
   *     minMessage="The name is too short.",
   *     maxMessage="The name is too long.",
   * )
   */
  protected $name;

  /**
   * @ORM\Column(type="string", length=255, nullable=true)
   *
   * @Assert\Length(
   *     min=3,
   *     max=255,
   *     minMessage="The soname is too short.",
   *     maxMessage="The soname is too long.",
   * )
   */
  protected $soname;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $age;

  /**
   * @ORM\Column(type="string", nullable=true)
   *
   * @Assert\Length(
   *     min=2,
   *     max=25,
   *     minMessage="So short City name.",
   *     maxMessage="So long City name.",
   * )
   */
  protected $city;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $img;

  /**
   * One User has Many Likes.
   * Used function __construct().
   *
   * @ORM\OneToMany(targetEntity="Like", mappedBy="user")
   */
  protected $like;

  /**
   * User constructor.
   */
  public function __construct() {
    parent::__construct();
    $this->like = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Set name
   *
   * @param string $name
   *
   * @return User
   */
  public function setName($name) {
    $this->name = $name;

    return $this;
  }

  /**
   * Get name
   *
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Set soname
   *
   * @param string $soname
   *
   * @return User
   */
  public function setSoname($soname) {
    $this->soname = $soname;

    return $this;
  }

  /**
   * Get soname
   *
   * @return string
   */
  public function getSoname() {
    return $this->soname;
  }

  /**
   * Set age
   *
   * @param integer $age
   *
   * @return User
   */
  public function setAge($age) {
    $this->age = $age;

    return $this;
  }

  /**
   * Get age
   *
   * @return integer
   */
  public function getAge() {
    return $this->age;
  }

  /**
   * Set city
   *
   * @param string $city
   *
   * @return User
   */
  public function setCity($city) {
    $this->city = $city;

    return $this;
  }

  /**
   * Get city
   *
   * @return string
   */
  public function getCity() {
    return $this->city;
  }

  /**
   * Set img
   *
   * @param string $img
   *
   * @return User
   */
  public function setImg($img) {
    $this->img = $img;

    return $this;
  }

  /**
   * Get img
   *
   * @return string
   */
  public function getImg() {
    return $this->img;
  }

  /**
   * Add comment
   *
   * @param \MainBundle\Entity\Comment $comment
   *
   * @return User
   */
  public function addComment(\MainBundle\Entity\Comment $comment) {
    $this->comments[] = $comment;

    return $this;
  }

  /**
   * Remove comment
   *
   * @param \MainBundle\Entity\Comment $comment
   */
  public function removeComment(\MainBundle\Entity\Comment $comment) {
    $this->comments->removeElement($comment);
  }

  /**
   * Get comments
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getComments() {
    return $this->comments;
  }

    /**
     * Set like
     *
     * @param \MainBundle\Entity\Like $like
     *
     * @return User
     */
    public function setLike(\MainBundle\Entity\Like $like = null)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * Get like
     *
     * @return \MainBundle\Entity\Like
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * Add like
     *
     * @param \MainBundle\Entity\Like $like
     *
     * @return User
     */
    public function addLike(\MainBundle\Entity\Like $like)
    {
        $this->like[] = $like;

        return $this;
    }

    /**
     * Remove like
     *
     * @param \MainBundle\Entity\Like $like
     */
    public function removeLike(\MainBundle\Entity\Like $like)
    {
        $this->like->removeElement($like);
    }
}
