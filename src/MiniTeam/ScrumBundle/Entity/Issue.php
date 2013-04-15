<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Issue
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 *
 * @ORM\Table(name="miniscrum_issue")
 * @ORM\Entity(repositoryClass="MiniTeam\ScrumBundle\Repository\IssueRepository")
 */
class Issue
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
     * @ORM\Column(name="content", type="text")
     */
    protected $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    protected $date;

    /**
     * @var \MiniTeam\ScrumBundle\Entity\UserStory
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\ScrumBundle\Entity\UserStory", inversedBy="issues")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $story;

    /**
     * @var bool
     * @ORM\Column(name="opened",type="boolean")
     */
    protected $opened;

    public function __construct()
    {
        $this->date = new \Datetime();
        $this->opened = true;
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
     * Set content
     *
     * @param  string $content
     * @return Issue
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return Issue
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set story
     *
     * @param  \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @return Issue
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story
     *
     * @return \MiniTeam\ScrumBundle\Entity\UserStory $story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Get opened/closed status
     *
     * @return bool
     */
    public function isOpened()
    {
        return $this->opened;
    }

    /**
     * Set opened/closed status
     *
     * @param  boolean $opened
     * @return Issue
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;

        return $this;
    }
}
