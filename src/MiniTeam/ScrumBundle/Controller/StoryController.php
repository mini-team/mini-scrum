<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Form\UserStoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

/**
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 * @author Edouard de Labareyre <edouard@melix.net>
 *
 * @Extra\Route("/{project}")
 */
class StoryController extends Controller
{
    /**
     * @Extra\Route("/backlog", name="project_backlog")
     * @Extra\ParamConverter("project", options={"mapping": {"project": "slug"}})
     * @Extra\Template()
     */
    public function backlogAction(Project $project)
    {
        return array('project' => $project);
    }

    /**
     * @Extra\Route("/us/{id}", name="story_show", requirements={"id" = "\d+"})
     * @Extra\Template()
     */
    public function showAction(UserStory $story)
    {
        return array('project' => $story->getProject(), 'story' => $story);
    }

    /**
     * @Extra\Route("/us/new", name="story_new")
     * @Extra\ParamConverter("project", options={"mapping": {"project": "name"}})
     * @Extra\Template()
     */
    public function newAction(Project $project, Request $request)
    {
        $story = new UserStory();
        $story->setProject($project);

        $form = $this->createForm(new UserStoryType(), $story);

        if ($request->isMethod('post')) {
            $response = $this->processForm($request, $form);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        return array('project' => $project, 'form' => $form->createView());
    }

    /**
     * Process the form of a UserStory
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\Form              $form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processForm(Request $request, Form $form)
    {
        $form->bind($request);

        if ($form->isValid()) {
            $story = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($story);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'story_show',
                    array(
                        'project' => $story->getProject()->getSlug(),
                        'id' => $story->getId()
                    )
                )
            );
        }
    }

    /**
     * @Extra\Route("/us/{id}/start", name="story_start", defaults={"status": "start"})
     * @Extra\Route("/us/{id}/deliver", name="story_deliver", defaults={"status": "deliver"}))
     *
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @param                                        $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateStatusAction(UserStory $story, $status)
    {
        switch ($status) {
            case 'start':
                $story->starts($this->getUser());
                break;
            case 'deliver':
                $story->deliver();
                break;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($story);
        $em->flush();

        return $this->redirect($this->generateUrl('story_show', array(
            'project' => $story->getProject()->getSlug(),
            'id' => $story->getId()
        )));
    }
}
