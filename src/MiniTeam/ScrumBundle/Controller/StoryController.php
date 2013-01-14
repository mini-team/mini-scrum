<?php

namespace MiniTeam\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

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
     * @Extra\Route("/{projectName}/{title}")
     * @Extra\Template()
     */
    public function showAction($projectName, $title)
    {
        return array('projectName' => $projectName, 'title' => $title);
    }
}
