<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class ProjectController extends Controller
{
    /**
     * @Extra\Route("/{name}")
     * @Extra\Template()
     */
    public function showAction(Project $project = null)
    {
        if (null == $project) {
            $project = $this->getUser()->getSelectedProject();
            $url     = $this->generateUrl('miniteam_scrum_project_show', array('name' => $project->getName()));

            return $this->redirect($url);
        }

        return array('project' => $project);
    }
    
    /**
     * @Extra\Template()
     */
    public function scrumBarAction($projectName,$activeTab)
    {
        //TODO get real scrum bar information
        return array('projectName' => $projectName,'activeTab'=>$activeTab);
    }
    

}
