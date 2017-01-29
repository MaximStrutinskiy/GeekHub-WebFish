<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Shop
 * @package MainBundle\Entity
 * @ORM\Table(name="shop")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\ShopRepository")
 **/
class Shop
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Image(
     *     minWidth = 250,
     *     maxWidth = 3500,
     *     minHeight = 250,
     *     maxHeight = 2500,
     *     maxSize = "5M",
     *     minWidthMessage="min width 250px.",
     *     maxWidthMessage="max width 3500px.",
     *     minHeightMessage="min height 250px.",
     *     maxHeightMessage="max height 2500px.",
     *     maxSizeMessage = "Too big img, max size = 5M."
     * )
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
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $productLike;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $productStatus;

    /**
     * Many Shop have Many Tags.
     * Used function __construct().
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="shop_tags",
     *      joinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $tag;

    /**
     * Many Shop have One Category.
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * One Shop has Many Comments.
     * Used function __construct().
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
     */
    protected $productComment;

    /**
     * One Shop has One User.
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="float")
     *
     * min = 1,
     * max = 1000,
     * minMessage = "You price to small {{ limit }}",
     * maxMessage = "You price to big {{ limit }}"
     */
    protected $productPrice;

    /**
     * Many User's can add many shops to favorite
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="favorite_user_shop",
     *      joinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $favorite;

    /**
     * Many User's can add many shops to favorite
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="cart_user_shop",
     *      joinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $cart;

    /**
     * Shop constructor.
     */
    public function __construct()
    {
        $this->shopComment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set productImg
     *
     * @param string $productImg
     *
     * @return Shop
     */
    public function setProductImg($productImg)
    {
        $this->productImg = $productImg;

        return $this;
    }

    /**
     * Get productImg
     *
     * @return string
     */
    public function getProductImg()
    {
        return $this->productImg;
    }

    /**
     * Set shortTitle
     *
     * @param string $shortTitle
     *
     * @return Shop
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;

        return $this;
    }

    /**
     * Get shortTitle
     *
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * Set longTitle
     *
     * @param string $longTitle
     *
     * @return Shop
     */
    public function setLongTitle($longTitle)
    {
        $this->longTitle = $longTitle;

        return $this;
    }

    /**
     * Get longTitle
     *
     * @return string
     */
    public function getLongTitle()
    {
        return $this->longTitle;
    }

    /**
     * Set shortDescriptions
     *
     * @param string $shortDescriptions
     *
     * @return Shop
     */
    public function setShortDescriptions($shortDescriptions)
    {
        $this->shortDescriptions = $shortDescriptions;

        return $this;
    }

    /**
     * Get shortDescriptions
     *
     * @return string
     */
    public function getShortDescriptions()
    {
        return $this->shortDescriptions;
    }

    /**
     * Set longDescriptions
     *
     * @param string $longDescriptions
     *
     * @return Shop
     */
    public function setLongDescriptions($longDescriptions)
    {
        $this->longDescriptions = $longDescriptions;

        return $this;
    }

    /**
     * Get longDescriptions
     *
     * @return string
     */
    public function getLongDescriptions()
    {
        return $this->longDescriptions;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Shop
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set productLike
     *
     * @param integer $productLike
     *
     * @return Shop
     */
    public function setProductLike($productLike)
    {
        $this->productLike = $productLike;

        return $this;
    }

    /**
     * Get productLike
     *
     * @return integer
     */
    public function getProductLike()
    {
        return $this->productLike;
    }

    /**
     * Set productStatus
     *
     * @param integer $productStatus
     *
     * @return Shop
     */
    public function setProductStatus($productStatus)
    {
        $this->productStatus = $productStatus;

        return $this;
    }

    /**
     * Get productStatus
     *
     * @return integer
     */
    public function getProductStatus()
    {
        return $this->productStatus;
    }

    /**
     * Set productPrice
     *
     * @param float $productPrice
     *
     * @return Shop
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return float
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Add tag
     *
     * @param \MainBundle\Entity\Tag $tag
     *
     * @return Shop
     */
    public function addTag(\MainBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \MainBundle\Entity\Tag $tag
     */
    public function removeTag(\MainBundle\Entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set category
     *
     * @param \MainBundle\Entity\Category $category
     *
     * @return Shop
     */
    public function setCategory(\MainBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \MainBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add productComment
     *
     * @param \MainBundle\Entity\Comment $productComment
     *
     * @return Shop
     */
    public function addProductComment(\MainBundle\Entity\Comment $productComment)
    {
        $this->productComment[] = $productComment;

        return $this;
    }

    /**
     * Remove productComment
     *
     * @param \MainBundle\Entity\Comment $productComment
     */
    public function removeProductComment(\MainBundle\Entity\Comment $productComment)
    {
        $this->productComment->removeElement($productComment);
    }

    /**
     * Get productComment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductComment()
    {
        return $this->productComment;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Shop
     */
    public function setUser(\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add favorite
     *
     * @param \MainBundle\Entity\User $favorite
     *
     * @return Shop
     */
    public function addFavorite(\MainBundle\Entity\User $favorite)
    {
        $this->favorite[] = $favorite;

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param \MainBundle\Entity\User $favorite
     */
    public function removeFavorite(\MainBundle\Entity\User $favorite)
    {
        $this->favorite->removeElement($favorite);
    }

    /**
     * Get favorite
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Add cart
     *
     * @param \MainBundle\Entity\User $cart
     *
     * @return Shop
     */
    public function addCart(\MainBundle\Entity\User $cart)
    {
        $this->cart[] = $cart;

        return $this;
    }

    /**
     * Remove cart
     *
     * @param \MainBundle\Entity\User $cart
     */
    public function removeCart(\MainBundle\Entity\User $cart)
    {
        $this->cart->removeElement($cart);
    }

    /**
     * Get cart
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCart()
    {
        return $this->cart;
    }
}
