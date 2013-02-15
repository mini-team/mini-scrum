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

    /**
     * @param \MiniTeam\ScrumBundle\Entity\Project $project
     * @param \MiniTeam\UserBundle\Entity\User     $user
     * @param \MiniTeam\UserBundle\Entity\User     $developer
     */
    function it_should_deliver_the_story($project, $user, $developer)
    {
        $project->getProductOwner()->willReturn($user);
        $this->setProject($project);

        $this->setAssignee($developer);
        $this->deliver();
        $this->getAssignee()->shouldReturn($user);
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::TO_VALIDATE);
    }

    function it_should_plan_the_story()
    {
        $this->plan();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::SPRINT_BACKLOG);
        $this->isPlanned()->shouldBe(true);
    }

    function it_should_unplan_the_story()
    {
        $this->unplan();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::PRODUCT_BACKLOG);
        $this->isPlanned()->shouldBe(false);
        $this->isInBacklog()->shouldBe(true);
    }

    /**
     * @param \MiniTeam\UserBundle\Entity\User $user
     */
    function it_should_refuse_the_story($user)
    {
        $this->setPreviousAssignee($user);

        $this->refuse();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::DOING);
        $this->getAssignee()->shouldEqual($user);
    }

    function it_should_accept_the_story()
    {
        $this->accept();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::DONE);
    }

    function it_should_block_the_story()
    {
        $this->block();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::BLOCKED);
    }

    function it_should_deblock_the_story()
    {
        $this->setStatus(\MiniTeam\ScrumBundle\Entity\UserStory::BLOCKED);

        $this->deblock();
        $this->getStatus()->shouldReturn(\MiniTeam\ScrumBundle\Entity\UserStory::SPRINT_BACKLOG);
    }
}
