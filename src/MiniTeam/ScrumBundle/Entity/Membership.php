<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\UserBundle\Entity\User;

/**
 * Member description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="membership")
 */
class Membership
{
    const PRODUCT_OWNER = 'product-owner';
    const SCRUM_MASTER  = 'scrum-master';
    const DEVELOPER     = 'developer';
    const MEMBER        = 'member';

    /**
     * @var Integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\ScrumBundle\Entity\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var Integer
     *
     * @ORM\Column(type="string", length=20)
     */
    protected $role;

    /**
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return \MiniTeam\ScrumBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return int
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isProductOwner()
    {
        return $this->getRole() == Membership::PRODUCT_OWNER;
    }
}
