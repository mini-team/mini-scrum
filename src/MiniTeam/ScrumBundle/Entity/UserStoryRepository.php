<?php

namespace MiniTeam\ScrumBundle\Entity;

use Doctrine\ORM\EntityRepository;

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
     * @param string $projectName
     * @param integer $status
     */
    public function countUserStoriesWithStatus($projectName, $status){

        $qb = $this->createQueryBuilder('us')
                   ->leftJoin('us.project','project','WITH','project.slug = :projectName')
                   ->where('us.status = :status')
                   ->setParameter('projectName',$projectName)
                   ->setParameter('status',$status);

        return count($qb->getQuery()->getArrayResult());

    }
}
