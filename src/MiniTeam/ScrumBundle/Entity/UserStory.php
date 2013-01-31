<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\UserBundle\Entity\User;

/**
 * UserStory
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 *
 * @ORM\Table(name="miniscrum_userstory")
 * @ORM\Entity(repositoryClass="MiniTeam\ScrumBundle\Entity\UserStoryRepository")
 */
class UserStory
{
    const PRODUCT_BACKLOG = 'product-backlog';
    const SPRINT_BACKLOG  = 'sprint-backlog';
    const DOING           = 'doing';
    const BLOCKED         = 'blocked';
    const TO_VALIDATE     = 'to-validate';
    const DONE            = 'done';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\Column(name="project_id", type="integer")
     */
    protected $projectId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    protected $details;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer", nullable=true)
     */
    protected $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    protected $number;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string",length=20)
     */
    protected $status;

    /**
     * @var \MiniTeam\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $assignee;

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
     * Set the project
     *
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     *
     * @return UserStory
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get the project
     *
     * @return \MiniTeam\ScrumBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param int $projectId
     *
     * @return UserStory
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set title
     *
     * @param  string    $title
     * @return UserStory
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
     * Set details
     *
     * @param  string    $details
     * @return UserStory
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set points
     *
     * @param  integer   $points
     * @return UserStory
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * Set number
     *
     * @param  integer   $number
     * @return UserStory
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set status
     *
     * @param  string    $status
     * @return UserStory
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $assignee
     *
     * @return UserStory
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return bool
     */
    public function isAssigned()
    {
        return $this->assignee instanceof User;
    }

    /**
     * @return bool
     */
    public function isPlanned()
    {
        return $this->status == self::SPRINT_BACKLOG;
    }

    /**
     * @return bool
     */
    public function isInProgress()
    {
        return $this->status == self::DOING;
    }

    /**
     * @return bool
     */
    public function isInBacklog()
    {
        return $this->status == self::PRODUCT_BACKLOG;
    }

    /**
     * Plan the story for the next sprint.
     */
    public function plan()
    {
        $this->setStatus(self::SPRINT_BACKLOG);
    }

    /**
     * Unplan the story. It goes back to the backlog.
     */
    public function unplan()
    {
        $this->setStatus(self::PRODUCT_BACKLOG);
    }

    /**
     * The user story starts, and it is assigned to a user.
     *
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    public function starts(User $user)
    {
        $this->setAssignee($user);
        $this->setStatus(self::DOING);
    }

    /**
     * Deliver the user story.
     * The status changes to "to validate"
     * and it is assigned to the product owner
     */
    public function deliver()
    {
        if (null !== ($user = $this->getProject()->getProductOwner())) {
            $this->setAssignee($user);
        }

        $this->setStatus(self::TO_VALIDATE);
    }
}
