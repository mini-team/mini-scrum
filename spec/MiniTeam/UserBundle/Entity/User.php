<?php

namespace spec\MiniTeam\UserBundle\Entity;

use PHPSpec2\ObjectBehavior;

class User extends ObjectBehavior
{
    /**
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     */
    function it_should_throw_an_exception_trying_getting_the_role_on_the_selected_project($project)
    {
        $project->getName()->willReturn('foo');

        $this->shouldThrow('\RuntimeException')->duringGetProjectRole($project);
    }

    /**
     * @param \MiniTeam\ScrumBundle\Entity\Membership $membership
     * @param \MiniTeam\ScrumBundle\Entity\Project    $project
     */
    function it_should_return_the_role_of_the_user_for_a_project($membership, $project)
    {
        $role = \MiniTeam\ScrumBundle\Entity\Membership::PRODUCT_OWNER;
        $membership->getRole()->willReturn($role);
        $membership->getProject()->willReturn($project);

        $this->getMemberships()->add($membership);
        $this->getProjectRole($project)->shouldReturn($role);
    }
}
