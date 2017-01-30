<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 *
 * @package MainBundle\Entity
 * @ORM\Table(name="post")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PostRepository")
 **/
class Post {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(type="string", nullable=true)
   */
  protected $postImg;

  /**
   * @ORM\Column(type="string", length=75, nullable=false)
   *
   * @Assert\Length(
   *     min=3,
   *     max=75,
   *     minMessage="min length > 3.",
   *     maxMessage="max length < 75.",
   * )
   */
  protected $shortTitle;

  /**
   * @ORM\Column(type="string", nullable=false)
   *
   * @Assert\Length(
   *     min=3,
   *     minMessage="min length > 3.",
   * )
   */
  protected $longTitle;

  /**
   * @ORM\Column(type="string", length=2000, nullable=false)
   *
   * @Assert\Length(
   *     min=3,
   *     max=255,
   *     minMessage="min length > 3.",
   *     maxMessage="max length < 1000.",
   * )
   */
  protected $shortDescriptions;

  /**
   * @ORM\Column(type="string", length=500000, nullable=false)
   * @Assert\Length(
   *      min = 1,
   *      max = 500000,
   *      minMessage = "Your first name must be at least {{ limit }} characters
   *   long", maxMessage = "Your first name cannot be longer than {{ limit }}
   *   characters"
   * )
   */
  protected $longDescriptions;

  /**
   * @ORM\Column(type="datetime")
   *
   * @Assert\DateTime()
   * @Assert\LessThanOrEqual("now")
   */
  protected $postDate;

  /**
   * @ORM\Column(type="integer", nullable=true)
   */
  protected $postLike;

  /**
   * @ORM\Column(type="integer", nullable=false)
   */
  protected $postStatus;

  /**
   * Many Post have Many Tags.
   * Used function __construct().
   *
   * @ORM\ManyToMany(targetEntity="Tag")
   * @ORM\JoinTable(name="post_tags",
   *      joinColumns={@ORM\JoinColumn(name="post_id",
   *   referencedColumnName="id")},
   *   inverseJoinColumns={@ORM\JoinColumn(name="tag_id",
   *   referencedColumnName="id", unique=false)}
   *      )
   */
  protected $tag;

  /**
   * Many Posts have One Category.
   * @ORM\ManyToOne(targetEntity="Category")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   */
  protected $category;

  /**
   * One Post has Many Comments.
   * Used function __construct().
   *
   * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
   */
  protected $postComment;

  /**
   * Many Posts have One User.
   * @ORM\ManyToOne(targetEntity="User")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * Post constructor.
   */
  public function __construct() {
    $this->postDate = new \DateTime();
    $this->postComment = new \Doctrine\Common\Collections\ArrayCollection();
    $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set postImg
   *
   * @param string $postImg
   *
   * @return Post
   */
  public function setPostImg($postImg) {
    $this->postImg = $postImg;

    return $this;
  }

  /**
   * Get postImg
   *
   * @return string
   */
  public function getPostImg() {
    return $this->postImg;
  }

  /**
   * Set shortTitle
   *
   * @param string $shortTitle
   *
   * @return Post
   */
  public function setShortTitle($shortTitle) {
    $this->shortTitle = $shortTitle;

    return $this;
  }

  /**
   * Get shortTitle
   *
   * @return string
   */
  public function getShortTitle() {
    return $this->shortTitle;
  }

  /**
   * Set longTitle
   *
   * @param string $longTitle
   *
   * @return Post
   */
  public function setLongTitle($longTitle) {
    $this->longTitle = $longTitle;

    return $this;
  }

  /**
   * Get longTitle
   *
   * @return string
   */
  public function getLongTitle() {
    return $this->longTitle;
  }

  /**
   * Set shortDescriptions
   *
   * @param string $shortDescriptions
   *
   * @return Post
   */
  public function setShortDescriptions($shortDescriptions) {
    $this->shortDescriptions = $shortDescriptions;

    return $this;
  }

  /**
   * Get shortDescriptions
   *
   * @return string
   */
  public function getShortDescriptions() {
    return $this->shortDescriptions;
  }

  /**
   * Set longDescriptions
   *
   * @param string $longDescriptions
   *
   * @return Post
   */
  public function setLongDescriptions($longDescriptions) {
    $this->longDescriptions = $longDescriptions;

    return $this;
  }

  /**
   * Get longDescriptions
   *
   * @return string
   */
  public function getLongDescriptions() {
    return $this->longDescriptions;
  }

  /**
   * Set postDate
   *
   * @param \DateTime $postDate
   *
   * @return Post
   */
  public function setPostDate($postDate) {
    $this->postDate = $postDate;

    return $this;
  }

  /**
   * Get postDate
   *
   * @return \DateTime
   */
  public function getPostDate() {
    return $this->postDate;
  }

  /**
   * Set postLike
   *
   * @param integer $postLike
   *
   * @return Post
   */
  public function setPostLike($postLike) {
    $this->postLike = $postLike;

    return $this;
  }

  /**
   * Get postLike
   *
   * @return integer
   */
  public function getPostLike() {
    return $this->postLike;
  }

  /**
   * Set postStatus
   *
   * @param integer $postStatus
   *
   * @return Post
   */
  public function setPostStatus($postStatus) {
    $this->postStatus = $postStatus;

    return $this;
  }

  /**
   * Get postStatus
   *
   * @return integer
   */
  public function getPostStatus() {
    return $this->postStatus;
  }

  /**
   * Add tag
   *
   * @param \MainBundle\Entity\Tag $tag
   *
   * @return Post
   */
  public function addTag(\MainBundle\Entity\Tag $tag) {
    $this->tag[] = $tag;

    return $this;
  }

  /**
   * Remove tag
   *
   * @param \MainBundle\Entity\Tag $tag
   */
  public function removeTag(\MainBundle\Entity\Tag $tag) {
    $this->tag->removeElement($tag);
  }

  /**
   * Get tag
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getTag() {
    return $this->tag;
  }

  /**
   * Set category
   *
   * @param \MainBundle\Entity\Category $category
   *
   * @return Post
   */
  public function setCategory(\MainBundle\Entity\Category $category = NULL) {
    $this->category = $category;

    return $this;
  }

  /**
   * Get category
   *
   * @return \MainBundle\Entity\Category
   */
  public function getCategory() {
    return $this->category;
  }

  /**
   * Add postComment
   *
   * @param \MainBundle\Entity\Comment $postComment
   *
   * @return Post
   */
  public function addPostComment(\MainBundle\Entity\Comment $postComment) {
    $this->postComment[] = $postComment;

    return $this;
  }

  /**
   * Remove postComment
   *
   * @param \MainBundle\Entity\Comment $postComment
   */
  public function removePostComment(\MainBundle\Entity\Comment $postComment) {
    $this->postComment->removeElement($postComment);
  }

  /**
   * Get postComment
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getPostComment() {
    return $this->postComment;
  }

  /**
   * Set user
   *
   * @param \MainBundle\Entity\User $user
   *
   * @return Post
   */
  public function setUser(\MainBundle\Entity\User $user = NULL) {
    $this->user = $user;

    return $this;
  }

  /**
   * Get user
   *
   * @return \MainBundle\Entity\User
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * Add user
   *
   * @param \MainBundle\Entity\User $user
   *
   * @return Post
   */
  public function addUser(\MainBundle\Entity\User $user) {
    $this->user[] = $user;

    return $this;
  }

  /**
   * Remove user
   *
   * @param \MainBundle\Entity\User $user
   */
  public function removeUser(\MainBundle\Entity\User $user) {
    $this->user->removeElement($user);
  }
}
