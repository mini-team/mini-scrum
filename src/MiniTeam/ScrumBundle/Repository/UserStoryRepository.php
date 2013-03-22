<?php

namespace MiniTeam\ScrumBundle\Repository;

use Doctrine\ORM\EntityRepository;
use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\ScrumBundle\Entity\UserStory;

/**
 * UserStoryRepository
 *
 * @author Edouard Garnier de Labareyre <edouard@melix.net>
 */
class UserStoryRepository extends EntityRepository
{

    /*
     * Get the number of user stories of a given status
     *
     * @param Project $project
     * @param integer $status
     */
    public function countUserStoriesWithStatus(Project $project, $status)
    {
        $qb = $this->createQueryBuilder('us');
        $qb
            ->select($qb->expr()->count('us.id'))
            ->leftJoin('us.project', 'project', 'WITH', 'project.slug = :slug')
            ->where('us.status = :status')
            ->setParameter('slug', $project->getSlug())
            ->setParameter('status', $status)
        ;

        return $qb->getQuery()->getSingleScalarResult();

    }
}
