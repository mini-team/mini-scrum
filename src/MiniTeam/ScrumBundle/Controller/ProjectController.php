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

        $usRepo = $this->getDoctrine()->getRepository('MiniTeamScrumBundle:UserStory');

        //TODO do it in one request
        $nb_product_backlog = $usRepo->countUserStoriesWithStatus($projectName,'product-backlog');
        $nb_sprint_backlog = $usRepo->countUserStoriesWithStatus($projectName,'sprint-backlog');
        $nb_doing = $usRepo->countUserStoriesWithStatus($projectName,'doing');
        $nb_blocked = $usRepo->countUserStoriesWithStatus($projectName,'blocked');
        $nb_to_validate = $usRepo->countUserStoriesWithStatus($projectName,'to-validate');
        $nb_done = $usRepo->countUserStoriesWithStatus($projectName,'done');

        return array(
            'projectName' => $projectName,
            'activeTab'=>$activeTab,
            'nb_product_backlog'=>$nb_product_backlog,
            'nb_sprint_backlog'=>$nb_sprint_backlog,
            'nb_doing'=>$nb_doing,
            'nb_blocked'=>$nb_blocked,
            'nb_to_validate'=>$nb_to_validate,
            'nb_done'=>$nb_done,
        );
    }
    

}
