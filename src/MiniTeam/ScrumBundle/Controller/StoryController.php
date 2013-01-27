<?php

namespace MiniTeam\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Project;

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
    public function showAction($projectName, UserStory $story)
    {
        return array('projectName' => $projectName, 'story' => $story);
    }

    /**
     * @Extra\Route("/{name}/us-list/{status}")
     * @Extra\Template()
     */
    public function listAction(Project $project, $status){

        //retrieve list of user stories of this project with the given status
        $usRepo = $this->getDoctrine()->getRepository('MiniTeamScrumBundle:UserStory');
        $stories = $usRepo->findBy(
            array('status' => $status,'project' => $project),
            array('number' => 'asc')
        );

        return array('projectName' => $project->getName(), 'stories' => $stories,'status'=>$status);
    }


}
