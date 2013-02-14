<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 *
 * @ORM\Table(name="miniscrum_comment")
 * @ORM\Entity(repositoryClass="MiniTeam\ScrumBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var \MiniTeam\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $author;

    /**
     * @var \MiniTeam\ScrumBundle\Entity\UserStory
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\ScrumBundle\Entity\UserStory")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $story;

    public function __construct()
    {
        $this->date = new \Datetime();
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
     * @param string $content
     * @return Comment
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
     * @param \DateTime $date
     * @return Comment
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
     * Set author
     *
     * @param \MiniTeam\UserBundle\Entity\User $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set story
     *
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @return Comment
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
}
