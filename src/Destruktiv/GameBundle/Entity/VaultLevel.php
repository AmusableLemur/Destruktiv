<?php

namespace Destruktiv\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VaultLevel
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class VaultLevel
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

