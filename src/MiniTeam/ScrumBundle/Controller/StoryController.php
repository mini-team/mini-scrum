<?php

namespace MiniTeam\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use MiniTeam\ScrumBundle\Entity\UserStory;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * @Extra\Route("/{projectName}")
 */
class StoryController extends Controller
{
    /**
     * @Extra\Route("/backlog")
     * @Extra\Template()
     */
    public function backlogAction($projectName)
    {
        return array('projectName' => $projectName);
    }

    /**
     * @Extra\Route("/us/{id}", requirements={"id" = "\d+"})
     * @Extra\Template()
     */
    public function showAction(UserStory $story)
    {
        return array('projectName' => $story->getProject(), 'story' => $story);
    }

    /**
     * @Extra\Route("/us/new", name="story_new")
     * @Extra\Template()
     */
    public function newAction($projectName)
    {
        return array('projectName' => $projectName);
    }
}
