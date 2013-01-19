<?php

namespace MiniTeam\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="miniscrum_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="MiniTeam\ScrumBundle\Entity\ProjectUser",
     *      mappedBy="projects",
     *      cascade={"persist", "remove", "merge"},
     *      fetch="EAGER"
     * )
     */
    protected $projectsUsers;

    /**
     * @var ArrayCollection
     */
    protected $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectsUsers = new ArrayCollection();

        parent::__construct();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProjects()
    {
        if (null === $this->projects) {
            $this->projects = new ArrayCollection();

            foreach ($this->projectsUsers as $pu) {
                $this->projects[] = $pu->getProject();
            }
        }

        return $this->projects;
    }
}
