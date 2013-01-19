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
     *      mappedBy="user",
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
     * @param \Doctrine\Common\Collections\ArrayCollection $projectsUsers
     */
    public function setProjectsUsers(ArrayCollection $projectsUsers)
    {
        $this->projectsUsers = $projectsUsers;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getProjectsUsers()
    {
        return $this->projectsUsers;
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

        foreach ($this->projectsUsers as $projectUser) {
            if ($projectUser->getProject() !== $project) {
                continue;
            }

            return $projectUser->getRole();
        }

        throw new \RuntimeException(sprintf('The user has no role on the project "%s".', $project->getName()));
    }
}
