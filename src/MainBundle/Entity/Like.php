<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Like
 *
 * @package MainBundle\Entity
 * @ORM\Table(name="likes")
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
   * Many Likes have Many User.
   *
   * @ORM\ManyToOne(targetEntity="User", inversedBy="like")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * Many Likes have One Post.
   *
   * @ORM\ManyToOne(targetEntity="Post", inversedBy="postLike")
   * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
   */
  protected $post;

  /**
   * Many Likes have One Product.
   *
   * @ORM\ManyToOne(targetEntity="Product", inversedBy="productLike")
   * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
   */
  protected $product;


  /**
   * Get id
   *
   * @return integer
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set user
   *
   * @param \MainBundle\Entity\User $user
   *
   * @return Like
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
   * Set post
   *
   * @param \MainBundle\Entity\Post $post
   *
   * @return Like
   */
  public function setPost(\MainBundle\Entity\Post $post = NULL) {
    $this->post = $post;

    return $this;
  }

  /**
   * Get post
   *
   * @return \MainBundle\Entity\Post
   */
  public function getPost() {
    return $this->post;
  }

    /**
     * Set product
     *
     * @param \MainBundle\Entity\Product $product
     *
     * @return Like
     */
    public function setProduct(\MainBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MainBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
