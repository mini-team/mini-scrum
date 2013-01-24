<?php

namespace MiniTeam\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use MiniTeam\ScrumBundle\Entity\UserStory;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class StoryController extends Controller
{
    /**
     * @Extra\Route("/{projectName}/backlog")
     * @Extra\Template()
     */
    public function backlogAction($projectName)
    {
        return array('projectName' => $projectName);
    }

    /**
     * @Extra\Route("/{projectName}/us/{id}")
     * @Extra\Template()
     */
    public function showAction(UserStory $story)
    {
        return array('projectName' => $story->getProject(), 'story' => $story);
    }


}
