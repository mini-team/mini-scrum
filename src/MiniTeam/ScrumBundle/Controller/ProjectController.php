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
     * @Extra\Route("/{name}")
     * @Extra\Template()
     */
    public function showAction($name)
    {
        return array('name' => $name);
    }
}
