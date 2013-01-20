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
     * @Extra\Route("/{projectName}/us/{id}")
     * @Extra\Template()
     */
    public function showAction($projectName, $id)
    {

        //get corresponding user story
        $em = $this->getDoctrine()->getManager();
        $userStory = $em->getRepository('MiniTeamScrumBundle:UserStory')->find($id);

        //display user story
        return array('projectName' => $projectName, 'userStory' => $userStory);
    }
}
