<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Tag
 * @package BlogBundle\Entity
 * @ORM\Table(name="tag")
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="MainBundle\Repository\TagRepository")
 **/
class Tag
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     *
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="min length > 3.",
     *     maxMessage="max length < 100.",
     * )
     */
    protected $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
