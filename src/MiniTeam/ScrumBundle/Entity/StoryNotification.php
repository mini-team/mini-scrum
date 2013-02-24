<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoryNotification
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 *
 * @ORM\Table(name="miniscrum_story_notif")
 * @ORM\Entity(repositoryClass="MiniTeam\ScrumBundle\Repository\StoryNotificationRepository")
 */
class StoryNotification
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
     * @var \MiniTeam\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $recipient;

    /**
     * @var \MiniTeam\ScrumBundle\Entity\UserStory
     *
     * @ORM\ManyToOne(targetEntity="MiniTeam\ScrumBundle\Entity\UserStory")
     * @ORM\JoinColumn(name="story_id", referencedColumnName="id")
     */
    protected $story;

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
     * Set recipient of story notification
     *
     * @param \MiniTeam\UserBundle\Entity\User $recipient
     * @return StoryNotification
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    
        return $this;
    }

    /**
     * Get recipient of story notification
     *
     * @return \MiniTeam\UserBundle\Entity\User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Set story the notification is about
     *
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @return StoryNotification
     */
    public function setStory($story)
    {
        $this->story = $story;

        return $this;
    }

    /**
     * Get story the notification is about
     *
     * @return \MiniTeam\ScrumBundle\Entity\UserStory $story
     */
    public function getStory()
    {
        return $this->story;
    }
}
