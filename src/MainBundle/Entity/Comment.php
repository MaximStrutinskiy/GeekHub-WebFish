<?php

namespace MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Comment
 *
 * @package MainBundle\Entity
 * @ORM\Table(name="comment")
 * @ORM\Entity()
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="MainBundle\Repository\CommentRepository")
 **/
class Comment
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\Length(
     *     min=1,
     *     max=20000,
     *     minMessage="Comment to short.",
     *     maxMessage="Comment is to long, max length 20000.",
     * )
     */
    protected $commentText;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $postDate;

    /**
     * @var Category
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(
     *      targetEntity="MainBundle\Entity\Comment",
     *      inversedBy="children"
     * )
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var Category[]
     *
     * @ORM\OneToMany(
     *      targetEntity="MainBundle\Entity\Comment",
     *      mappedBy="parent"
     * )
     */
    private $children;

    /**
     * Many Comments have One Post.
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="postComment")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    /**
     * Many Comments have One Shop.
     *
     * @ORM\ManyToOne(targetEntity="Shop", inversedBy="productComment")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * Many Comment have One Address.
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    public function __construct()
    {
        $this->postDate = new \DateTime();
        $this->children = new ArrayCollection();
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
     * Set commentText
     *
     * @param string $commentText
     *
     * @return Comment
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;

        return $this;
    }

    /**
     * Get commentText
     *
     * @return string
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Comment
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
     * Set parent
     *
     * @param \MainBundle\Entity\Comment $parent
     *
     * @return Comment
     */
    public function setParent(\MainBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MainBundle\Entity\Comment
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \MainBundle\Entity\Comment $child
     *
     * @return Comment
     */
    public function addChild(\MainBundle\Entity\Comment $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \MainBundle\Entity\Comment $child
     */
    public function removeChild(\MainBundle\Entity\Comment $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set post
     *
     * @param \MainBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\MainBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \MainBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set product
     *
     * @param \MainBundle\Entity\Shop $product
     *
     * @return Comment
     */
    public function setProduct(\MainBundle\Entity\Shop $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MainBundle\Entity\Shop
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Comment
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
}
