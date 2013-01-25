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
     */
    public function countUserStoriesWithStatus($status){

        $qb = $this->createQueryBuilder('us')
                   ->where('us.status = :status')
                   ->setParameter('status',$status);

        return count($qb->getQuery()->getArrayResult());

    }
}
