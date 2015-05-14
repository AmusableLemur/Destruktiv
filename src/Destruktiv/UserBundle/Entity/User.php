<?php

namespace Destruktiv\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Destruktiv\ForumBundle\Entity\Thread", mappedBy="author")
     **/
    private $threads;

    /**
     * @ORM\OneToMany(targetEntity="Destruktiv\ForumBundle\Entity\Post", mappedBy="author")
     **/
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity="Destruktiv\GameBundle\Entity\VaultLevel")
     */
    private $vaultLevel;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Set name
     *
     * @param string $name
     * @return User
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

    /**
     * Add threads
     *
     * @param \Destruktiv\ForumBundle\Entity\Thread $threads
     * @return User
     */
    public function addThread(\Destruktiv\ForumBundle\Entity\Thread $threads)
    {
        $this->threads[] = $threads;

        return $this;
    }

    /**
     * Remove threads
     *
     * @param \Destruktiv\ForumBundle\Entity\Thread $threads
     */
    public function removeThread(\Destruktiv\ForumBundle\Entity\Thread $threads)
    {
        $this->threads->removeElement($threads);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThreads()
    {
        return $this->threads;
    }

    /**
     * Add post
     *
     * @param \Destruktiv\ForumBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\Destruktiv\ForumBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Destruktiv\ForumBundle\Entity\Post $post
     */
    public function removePost(\Destruktiv\ForumBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
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
     * Set vaultLevel
     *
     * @param \Destruktiv\GameBundle\Entity\VaultLevel $vaultLevel
     *
     * @return User
     */
    public function setVaultLevel(\Destruktiv\GameBundle\Entity\VaultLevel $vaultLevel = null)
    {
        $this->vaultLevel = $vaultLevel;

        return $this;
    }

    /**
     * Get vaultLevel
     *
     * @return \Destruktiv\GameBundle\Entity\VaultLevel
     */
    public function getVaultLevel()
    {
        return $this->vaultLevel;
    }
}
