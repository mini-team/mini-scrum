<?php

namespace spec\MiniTeam\ScrumBundle\Entity;

use PHPSpec2\ObjectBehavior;
use MiniTeam\ScrumBundle\Entity\Membership;

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

    /**
     * @param \MiniTeam\UserBundle\Entity\User $firstDeveloper
     * @param \MiniTeam\UserBundle\Entity\User $secondeDeveloper
     */
    function it_shoud_add_a_developer($firstDeveloper, $secondeDeveloper)
    {
        $this->addDeveloper($firstDeveloper);
        $this->getDevelopers()->shouldHaveCount(1);

        $this->addDeveloper($secondeDeveloper);
        $this->getDevelopers()->shouldHaveCount(2);
    }
}
