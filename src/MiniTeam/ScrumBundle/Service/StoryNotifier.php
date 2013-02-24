<?php

namespace MiniTeam\ScrumBundle\Service;

use MiniTeam\ScrumBundle\Entity\Comment;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\StoryNotification;
use MiniTeam\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class StoryNotifier
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Add a notification for a given story in the stack of a given user
     * @param \MiniTeam\ScrumBundle\Entity\Comment $comment
     */
    public function addStoryNotificationForComment(Comment $comment)
    {
        $story   = $comment->getStory();
        $author  = $comment->getAuthor();
        $project = $story->getProject();

        //add story notification to all users which are likely to be concerned by this comment
        if ($author->getRole($project) == \MiniTeam\ScrumBundle\Entity\Membership::PRODUCT_OWNER) {
            if ( $story->getAssignee() != null ) {
                $this->em->persist($this->newStoryNotification($story, $story->getAssignee()));
            } else {
                foreach ( $project->getDevelopers() as $dev) {
                    $this->em->persist($this->newStoryNotification($story, $dev));
                }
            }
        } elseif ($author->getRole($project) == \MiniTeam\ScrumBundle\Entity\Membership::DEVELOPER) {
            $this->em->persist($this->newStoryNotification($story, $project->getProductOwner()));
        }

        $this->em->flush();
    }

    /**
     * Reset notification on a story for a given user
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @param \MiniTeam\UserBundle\Entity\User       $user
     */
    public function resetStoryNotification(UserStory $story, User $user)
    {
        $notifications = $this->em->getRepository('MiniTeamScrumBundle:StoryNotification')->findBy(
            array(
                'story' => $story,
                'recipient'=> $user
            )
        );
        foreach ($notifications as $notification) {
            $this->em->remove($notification);
        }
        $this->em->flush();
    }

    /**
     * Create story notification for a given user
     *
     * @param  \MiniTeam\ScrumBundle\Entity\UserStory         $story
     * @param  \MiniTeam\UserBundle\Entity\User               $recipient
     * @return \MiniTeam\ScrumBundle\Entity\StoryNotification $notification
     */
    protected function newStoryNotification($story, $recipient)
    {
        $notification = new StoryNotification();
        $notification->setRecipient($recipient);
        $notification->setStory($story);

        return $notification;
    }
}
