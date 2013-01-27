<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $id;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\ScrumBundle\Entity\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;
    
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var integer
     *
     * @ORM\Column(name="points", type="integer")
     */
    private $points;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="string",length=20)
     */
    private $status;

    
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
     * Set project
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return \MiniTeam\ScrumBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }
    
    /**
     * Set title
     *
     * @param string $title
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
     * @param string $details
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
     * @param integer $points
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
     * @param integer $number
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
     * @param integer $status
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
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

}
