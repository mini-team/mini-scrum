<?php

namespace spec\MiniTeam\ScrumBundle\Entity;

use PHPSpec2\ObjectBehavior;

class UserStory extends ObjectBehavior
{
    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    function it_should_be_started_by_a_user($user)
    {
        $this->starts($user);

        $this->getAssignee()->shouldReturn($user);
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::DOING);
    }
}
