<?php

namespace MiniTeam\ScrumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class ProjectController extends Controller
{
    /**
     * @Extra\Route("/{projectName}")
     * @Extra\Template()
     */
    public function showAction($projectName)
    {
        return array('projectName' => $projectName);
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
