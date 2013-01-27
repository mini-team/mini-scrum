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
     * @Extra\Route("/{project}", name="project_show")
     * @Extra\ParamConverter("project", options={ "mapping": { "project": "slug" } })
     * @Extra\Template()
     */
    public function showAction(Project $project = null)
    {
        if (null == $project) {
            $project = $this->getUser()->getSelectedProject();
            $url     = $this->generateUrl('project_show', array('project' => $project->getSlug()));

            return $this->redirect($url);
        }

        return array('project' => $project);
    }

    /**
     * @Extra\Template()
     */
    public function scrumBarAction($project, $activeTab)
    {
        $project = $this->getDoctrine()
            ->getRepository('MiniTeamScrumBundle:Project')
            ->findOneBySlug($project);

        //TODO get real scrum bar information
        return array('project' => $project, 'activeTab' => $activeTab);
    }

}
