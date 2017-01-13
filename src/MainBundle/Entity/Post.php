<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Post
 * @package BlogBundle\Entity
 * @ORM\Table(name="post")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\PostRepository")
 **/
class Post
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
     *     minWidth = 800,
     *     maxWidth = 3500,
     *     minHeight = 400,
     *     maxHeight = 2500,
     *     maxSize = "5M",
     *     minWidthMessage="min width 800px.",
     *     maxWidthMessage="max width 3500px.",
     *     minHeightMessage="min height 400px.",
     *     maxHeightMessage="max height 2500px.",
     *     maxSizeMessage = "Too big img, max size = 5M."
     * )
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
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\Length(
     *     min=3,
     *     minMessage="min length > 3.",
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
     * One Post has Many Comments.
     * Used function __construct().
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    protected $comment;

    /**
     * Many Post have Many Tags.
     * Used function __construct().
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="post_tags",
     *      joinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id", unique=false)}
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
     * One Post has One User.
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set postImg
     *
     * @param string $postImg
     *
     * @return Post
     */
    public function setPostImg($postImg)
    {
        $this->postImg = $postImg;

        return $this;
    }

    /**
     * Get postImg
     *
     * @return string
     */
    public function getPostImg()
    {
        return $this->postImg;
    }

    /**
     * Set shortTitle
     *
     * @param string $shortTitle
     *
     * @return Post
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
     * @return Post
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
     * @return Post
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
     * @return Post
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
     * @return Post
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
     * Add comment
     *
     * @param \BlogBundle\Entity\Comment $comment
     *
     * @return Post
     */
    public function addComment(\BlogBundle\Entity\Comment $comment)
    {
        $this->comment[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \BlogBundle\Entity\Comment $comment
     */
    public function removeComment(\BlogBundle\Entity\Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Add tag
     *
     * @param \BlogBundle\Entity\Tag $tag
     *
     * @return Post
     */
    public function addTag(\BlogBundle\Entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \BlogBundle\Entity\Tag $tag
     */
    public function removeTag(\BlogBundle\Entity\Tag $tag)
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
     * @param \BlogBundle\Entity\Category $category
     *
     * @return Post
     */
    public function setCategory(\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user
     *
     * @param \BlogBundle\Entity\User $user
     *сфеупщ
     * @return Post
     */
    public function setUser(\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
