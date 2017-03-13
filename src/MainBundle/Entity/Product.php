<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 *
 * @package MainBundle\Entity
 * @ORM\Table(name="product")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ProductRepository")
 **/
class Product {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @ORM\Column(type="array", nullable=true)
   */
  protected $productImg;

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
   * @ORM\Column(type="string", length=255, nullable=false)
   *
   * @Assert\Length(
   *     min=3,
   *     max=255,
   *     minMessage="min length > 3.",
   *     maxMessage="max length < 255.",
   * )
   */
  protected $shortDescriptions;

  /**
   * @ORM\Column(type="string", length=500000, nullable=false)
   *
   * @Assert\Length(
   *      min = 1,
   *      max = 500000,
   *      minMessage = "Your first name must be at least {{ limit }} characters long",
   *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
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
   * One Product has Many Likes.
   * Used function __construct().
   *
   * @ORM\OneToMany(targetEntity="Like", mappedBy="product")
   */
  protected $productLike;

  /**
   * @ORM\Column(type="integer", nullable=false)
   */
  protected $postStatus;

  /**
   * Many Product have Many Tags.
   * Used function __construct().
   *
   * @ORM\ManyToMany(targetEntity="Tag")
   * @ORM\JoinTable(name="Product_tags",
   *      joinColumns={@ORM\JoinColumn(name="Product_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=false)}
   *      )
   */
  protected $tag;

  /**
   * Many Product have One Category.
   * @ORM\ManyToOne(targetEntity="Category")
   * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
   */
  protected $category;

  /**
   * One Product has Many Comments.
   * Used function __construct().
   *
   * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
   */
  protected $productComment;

  /**
   * One Product has One User.
   * @ORM\OneToOne(targetEntity="User")
   * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
   */
  protected $user;

  /**
   * @ORM\Column(type="float")
   *
   * min = 1,
   * max = 1000,
   * minMessage = "You price to small {{ limit }}, must be > 1$",
   * maxMessage = "You price to big {{ limit }}, must be < 1000$"
   */
  protected $productPrice;

  /**
   * Many User's can add many Products to favorite
   *
   * @ORM\ManyToMany(targetEntity="User")
   * @ORM\JoinTable(name="favorite_user_product",
   *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
   *      )
   */
  protected $favorite;

  /**
   * Many User's can add many Products to favorite
   *
   * @ORM\ManyToMany(targetEntity="User")
   * @ORM\JoinTable(name="cart_user_product",
   *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
   *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
   *      )
   */
  protected $cart;

  /**
   * Product constructor.
   */
  public function __construct() {
    $this->productImg = new \Doctrine\Common\Collections\ArrayCollection();
    $this->productComment = new \Doctrine\Common\Collections\ArrayCollection();
    $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    $this->productLike = new \Doctrine\Common\Collections\ArrayCollection();
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
   * Set productImg
   *
   * @param array $productImg
   *
   * @return Product
   */
  public function setProductImg($productImg) {
    $this->productImg = $productImg;

    return $this;
  }

  /**
   * Get productImg
   *
   * @return array
   */
  public function getProductImg() {
    return $this->productImg;
  }

  /**
   * Set shortTitle
   *
   * @param string $shortTitle
   *
   * @return Product
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
   * @return Product
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
   * @return Product
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
   * @return Product
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
   * @return Product
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
   * Set productLike
   *
   * @param integer $productLike
   *
   * @return Product
   */
  public function setProductLike($productLike) {
    $this->productLike = $productLike;

    return $this;
  }

  /**
   * Get productLike
   *
   * @return integer
   */
  public function getProductLike() {
    return $this->productLike;
  }

  /**
   * Set postStatus
   *
   * @param integer $postStatus
   *
   * @return Product
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
   * Set productPrice
   *
   * @param float $productPrice
   *
   * @return Product
   */
  public function setProductPrice($productPrice) {
    $this->productPrice = $productPrice;

    return $this;
  }

  /**
   * Get productPrice
   *
   * @return float
   */
  public function getProductPrice() {
    return $this->productPrice;
  }

  /**
   * Add tag
   *
   * @param \MainBundle\Entity\Tag $tag
   *
   * @return Product
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
   * @return Product
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
   * Add productComment
   *
   * @param \MainBundle\Entity\Comment $productComment
   *
   * @return Product
   */
  public function addProductComment(\MainBundle\Entity\Comment $productComment) {
    $this->productComment[] = $productComment;

    return $this;
  }

  /**
   * Remove productComment
   *
   * @param \MainBundle\Entity\Comment $productComment
   */
  public function removeProductComment(\MainBundle\Entity\Comment $productComment) {
    $this->productComment->removeElement($productComment);
  }

  /**
   * Get productComment
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getProductComment() {
    return $this->productComment;
  }

  /**
   * Set user
   *
   * @param \MainBundle\Entity\User $user
   *
   * @return Product
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
   * Add favorite
   *
   * @param \MainBundle\Entity\User $favorite
   *
   * @return Product
   */
  public function addFavorite(\MainBundle\Entity\User $favorite) {
    $this->favorite[] = $favorite;

    return $this;
  }

  /**
   * Remove favorite
   *
   * @param \MainBundle\Entity\User $favorite
   */
  public function removeFavorite(\MainBundle\Entity\User $favorite) {
    $this->favorite->removeElement($favorite);
  }

  /**
   * Get favorite
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getFavorite() {
    return $this->favorite;
  }

  /**
   * Add cart
   *
   * @param \MainBundle\Entity\User $cart
   *
   * @return Product
   */
  public function addCart(\MainBundle\Entity\User $cart) {
    $this->cart[] = $cart;

    return $this;
  }

  /**
   * Remove cart
   *
   * @param \MainBundle\Entity\User $cart
   */
  public function removeCart(\MainBundle\Entity\User $cart) {
    $this->cart->removeElement($cart);
  }

  /**
   * Get cart
   *
   * @return \Doctrine\Common\Collections\Collection
   */
  public function getCart() {
    return $this->cart;
  }

    /**
     * Add productLike
     *
     * @param \MainBundle\Entity\Like $productLike
     *
     * @return Product
     */
    public function addProductLike(\MainBundle\Entity\Like $productLike)
    {
        $this->productLike[] = $productLike;

        return $this;
    }

    /**
     * Remove productLike
     *
     * @param \MainBundle\Entity\Like $productLike
     */
    public function removeProductLike(\MainBundle\Entity\Like $productLike)
    {
        $this->productLike->removeElement($productLike);
    }
}
