<?php

namespace spec\MiniTeam\ScrumBundle\Entity;

use PHPSpec2\ObjectBehavior;
use MiniTeam\ScrumBundle\Entity\ProjectUser;

class Project extends ObjectBehavior
{
    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    function it_should_add_a_user_as_product_owner($user)
    {
        $this->setProductOwner($user);
        $this->getProductOwner()->shoudReturnAnInstanceOf('\MiniTeam\UserBundle\Entity\User');
        $this->getUsers()->shouldHaveCount(1);
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    function it_should_add_a_user_as_scrum_master($user)
    {
        $this->setScrumMaster($user);
        $this->getScrumMaster()->shoudReturnAnInstanceOf('\MiniTeam\UserBundle\Entity\User');
        $this->getUsers()->shouldHaveCount(1);
    }
}
