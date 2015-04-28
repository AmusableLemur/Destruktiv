<?php

namespace Destruktiv\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Thread
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Thread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Destruktiv\UserBundle\Entity\User", inversedBy="threads")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="thread")
     **/
    private $posts;


    public function __construct() {
        $this->posts = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Thread
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add posts
     *
     * @param \Destruktiv\ForumBundle\Entity\Post $posts
     * @return Thread
     */
    public function addPost(\Destruktiv\ForumBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \Destruktiv\ForumBundle\Entity\Post $posts
     */
    public function removePost(\Destruktiv\ForumBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set author
     *
     * @param \Destruktiv\UserBundle\Entity\User $author
     * @return Thread
     */
    public function setAuthor(\Destruktiv\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Destruktiv\UserBundle\Entity\User 
     */
    public function getAuthor()
    {
        return $this->author;
    }
}
