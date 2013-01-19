<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use MiniTeam\UserBundle\Entity\User;
use MiniTeam\ScrumBundle\Entity\ProjectUser;

/**
 * Project description
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="project")
 *
 * @todo:
 * - if PO is null getProductOwner should look for it in the users collection
 * - if SM is null getScrumMaster should look for it in the users collection
 */
class Project
{
    /**
     * @var Integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     *
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @var String
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=128, unique=true)
     */
    protected $slug;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="MiniTeam\ScrumBundle\Entity\ProjectUser",
     *      mappedBy="project",
     *      cascade={"persist", "remove", "merge"},
     *      fetch="EAGER"
     * )
     */
    protected $projectsUsers;

    /**
     * This is a cache for users of ProjectUsers relations.
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $users;

    /**
     * @var \MiniTeam\UserBundle\Entity\User
     */
    protected $productOwner;

    /**
     * @var \MiniTeam\UserBundle\Entity\User
     */
    protected $scrumMaster;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projectsUsers = new ArrayCollection();
    }

    /**
     * @return String
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return String
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getUsers()
    {
        if (null === $this->users ||
            $this->projectsUsers->count() > $this->users->count()
        ) {
            $this->users = $this->projectsUsers->map(function ($pu) { return $pu->getUser(); });
        }

        return $this->users;
    }

    /**
     * Add a user to the project.
     * @param \MiniTeam\UserBundle\Entity\User $user
     * @param null                             $role
     */
    public function addUser(User $user, $role = null)
    {
        $pu = new ProjectUser();
        $pu->setProject($this);
        $pu->setUser($user);
        $pu->setRole($role ?: ProjectUser::MEMBER);

        $this->projectsUsers->add($pu);
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    public function setProductOwner(User $user)
    {
        $this->productOwner = $user;

        $this->addUser($user, ProjectUser::PRODUCT_OWNER);
    }

    /**
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getProductOwner()
    {
        return $this->productOwner;
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    public function setScrumMaster(User $user)
    {
        $this->scrumMaster = $user;

        $this->addUser($user, ProjectUser::SCRUM_MASTER);
    }

    /**
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getScrumMaster()
    {
        return $this->scrumMaster;
    }
}
