<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Comment
 * @package BlogBundle\Entity
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
     * @ORM\Column(type="string", length=20000)
     *
     * @Assert\Length(
     *     min=1,
     *     max=75,
     *     minMessage="Comment to short.",
     *     maxMessage="Comment is to long, max length 20000.",
     * )
     */
    protected $commentPost;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $postDate;

    /**
     * Many Comments have One Post.
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comment")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    protected $post;

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
     * Set commentPost
     *
     * @param string $commentPost
     *
     * @return Comment
     */
    public function setCommentPost($commentPost)
    {
        $this->commentPost = $commentPost;

        return $this;
    }

    /**
     * Get commentPost
     *
     * @return string
     */
    public function getCommentPost()
    {
        return $this->commentPost;
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
     * @param \BlogBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(\BlogBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \BlogBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
