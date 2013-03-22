<?php

namespace MiniTeam\ScrumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Issue;

/**
 * IssueRepository
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 */
class IssueRepository extends EntityRepository
{
    /**
     * Mark all opened issues of a given user story as solved
     * @param UserStory $story
     */
    public function solveIssuesOnStory(UserStory $story)
    {
        $qb = $this->createQueryBuilder('issue');
        $qb
            ->update('MiniTeam\ScrumBundle\Entity\Issue','issue')
            ->set('issue.opened','false')
            ->where('issue.story = :us')
            ->setParameter('us',$story);
        $qb->getQuery()->execute();
    }
}
