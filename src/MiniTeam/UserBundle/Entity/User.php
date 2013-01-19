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
     *      targetEntity="MiniTeam\ScrumBundle\Entity\Membership",
     *      mappedBy="user",
     *      cascade={"persist", "remove", "merge"},
     *      fetch="EAGER"
     * )
     */
    protected $memberships;

    /**
     * @var ArrayCollection
     */
    protected $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->memberships = new ArrayCollection();

        parent::__construct();
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $memberships
     */
    public function setMemberships(ArrayCollection $memberships)
    {
        $this->memberships = $memberships;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMemberships()
    {
        return $this->memberships;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProjects()
    {
        if (null === $this->projects) {
            $this->projects = new ArrayCollection();

            foreach ($this->memberships as $membership) {
                $this->projects[] = $membership->getProject();
            }
        }

        return $this->projects;
    }

    /**
     * Return the current used project.
     *
     * @return \MiniTeam\ScrumBundle\Entity\Project
     * @todo use a listener to set the selected project when selection will be implemented
     */
    public function getSelectedProject()
    {
        return $this->getProjects()->first();
    }

    /**
     * Return the role of the user on the selected project.
     *
     * @param null $project
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function getProjectRole($project = null)
    {
        if (null == $project) {
            $project = $this->getSelectedProject();
        }

        foreach ($this->memberships as $membership) {
            if ($membership->getProject() !== $project) {
                continue;
            }

            return $membership->getRole();
        }

        throw new \RuntimeException(sprintf('The user has no role on the project "%s".', $project->getName()));
    }
}
