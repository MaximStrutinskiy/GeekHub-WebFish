<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
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
}
