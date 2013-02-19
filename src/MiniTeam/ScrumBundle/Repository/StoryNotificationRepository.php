<?php

namespace MiniTeam\ScrumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\UserBundle\Entity\User;
/**
 * StoryNotificationRepository
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 */
class StoryNotificationRepository extends EntityRepository
{
    /*
     * Get all the story notifications of a given user for a given project
     *
     * @param Project $project
     * @param User $user
     */
    public function findAllByUserOnProject(Project $project, User $recipient)
    {
        //TODO filter by project in the query
        $qb = $this->createQueryBuilder('notif');
        $qb->distinct()
           ->where('notif.recipient = :recipient')
           ->setParameter('recipient', $recipient)
        ;

        return $qb->getQuery()->getResult();
    }
}
