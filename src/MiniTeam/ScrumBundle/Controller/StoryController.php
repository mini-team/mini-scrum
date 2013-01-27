<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\ScrumBundle\Entity\UserStory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class StoryController extends Controller
{
    /**
     * @Extra\Route("/{project}/backlog", name="project_backlog")
     * @Extra\ParamConverter("project", options={"mapping": {"project": "slug"}})
     * @Extra\Template()
     */
    public function backlogAction(Project $project)
    {
        return array('project' => $project);
    }

    /**
     * @Extra\Route("/{project}/us/{id}", name="story_show")
     * @Extra\Template()
     */
    public function showAction(UserStory $story)
    {
        return array('project' => $story->getProject(), 'story' => $story);
    }


}
