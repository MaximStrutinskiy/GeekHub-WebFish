<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Comment
 *
 * @Gedmo\Tree(type="nested")
 * @package MainBundle\Entity
 * @ORM\Table(name="comment")
 * @ORM\Entity()
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

//
  /**
   * @Gedmo\TreeLeft
   * @ORM\Column(type="integer")
   */
  private $lft;

  /**
   * @Gedmo\TreeLevel
   * @ORM\Column(type="integer")
   */
  private $lvl;

  /**
   * @Gedmo\TreeRight
   * @ORM\Column(type="integer")
   */
  private $rgt;

  /**
   * @Gedmo\TreeRoot
   * @ORM\ManyToOne(targetEntity="Category")
   * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
   */
  private $root;

  /**
   * @Gedmo\TreeParent
   * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
   * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
   */
  private $parent;

  /**
   * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
   * @ORM\OrderBy({"lft" = "ASC"})
   */
  private $children;


//

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
     * Many User have Many Comments.
     * Used function __construct().
     *
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_comments",
     *      joinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id", unique=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=false)}
     *      )
     */
    protected $user;

    public function __construct()
    {
        $this->postDate = new \DateTime();
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add user
     *
     * @param \MainBundle\Entity\User $user
     *
     * @return Comment
     */
    public function addUser(\MainBundle\Entity\User $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \MainBundle\Entity\User $user
     */
    public function removeUser(\MainBundle\Entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     *
     * @return Comment
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     *
     * @return Comment
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     *
     * @return Comment
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param \MainBundle\Entity\Category $root
     *
     * @return Comment
     */
    public function setRoot(\MainBundle\Entity\Category $root = null)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return \MainBundle\Entity\Category
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set parent
     *
     * @param \MainBundle\Entity\Category $parent
     *
     * @return Comment
     */
    public function setParent(\MainBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MainBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add child
     *
     * @param \MainBundle\Entity\Category $child
     *
     * @return Comment
     */
    public function addChild(\MainBundle\Entity\Category $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \MainBundle\Entity\Category $child
     */
    public function removeChild(\MainBundle\Entity\Category $child)
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
}
