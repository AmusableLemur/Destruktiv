<?php

namespace Destruktiv\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Post
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
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="posts")
     */
    private $thread;


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
     * Set thread
     *
     * @param \Destruktiv\ForumBundle\Entity\Thread $thread
     * @return Post
     */
    public function setThread(\Destruktiv\ForumBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Destruktiv\ForumBundle\Entity\Thread
     */
    public function getThread()
    {
        return $this->thread;
    }
}
