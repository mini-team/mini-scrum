<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\Project;
use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Comment;
use MiniTeam\ScrumBundle\Entity\Issue;
use MiniTeam\ScrumBundle\Form\UserStoryType;
use MiniTeam\ScrumBundle\Repository\IssueRepository;
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
     * @Extra\Route("/us/{id}", name="story_show", requirements={"id" = "\d+"})
     * @Extra\ParamConverter("project", options={"mapping": {"project": "slug"}})
     * @Extra\Template()
     */
    public function showAction(Project $project, UserStory $story)
    {
        //remove notifications on this story
        $this->get('mini_team_scrum.notifier.story_notifier')
            ->resetStoryNotification($story, $this->getUser());

        //create comment form
        $comment = new Comment();
        $comment->setStory($story);
        $commentForm = $this->createFormBuilder($comment)
            ->add('content', 'text')
            ->getForm()
            ->createView();

        //create issue form if product owner and to validate
        $issueForm=null;
        if ($story->getStatus()=='to-validate' && $this->getUser()->isProductOwner($project)) {
            $issue = new Issue();
            $issue->setStory($story);
            $issueForm = $this->createFormBuilder($issue)
                ->add('content', 'text')
                ->getForm()
                ->createView();
        }

        return array(
            'project' => $project,
            'story' => $story,
            'commentForm' => $commentForm,
            'issueForm'=> $issueForm
        );
    }

    /**
     * @Extra\Route("/us-list/{status}", name="story_list")
     * @Extra\ParamConverter("project", options={"mapping": {"project": "slug"}})
     * @Extra\Template()
     */
    public function listAction(Project $project, $status)
    {
        //retrieve list of user stories of this project with the given status
        $stories = $this->getDoctrine()
            ->getRepository('MiniTeamScrumBundle:UserStory')
            ->findBy(
                array('status' => $status,'project' => $project),
                array('number' => 'asc')
            )
        ;

        if (count($stories) == 1) {
            $story = reset($stories);

            return $this->redirect(
                $this->generateUrl(
                    'story_show',
                    array(
                        'project' => $story->getProject()->getSlug(),
                        'id'      => $story->getId()
                    )
                )
            );
        }

        return array('project' => $project, 'stories' => $stories,'status'=>$status);
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
     * @Extra\Route("/us/{id}/unplan", name="story_unplan", defaults={"status": "unplan"})
     * @Extra\Route("/us/{id}/plan", name="story_plan", defaults={"status": "plan"})
     * @Extra\Route("/us/{id}/start", name="story_start", defaults={"status": "start"})
     * @Extra\Route("/us/{id}/deliver", name="story_deliver", defaults={"status": "deliver"}))
     * @Extra\Route("/us/{id}/refuse", name="story_refuse", defaults={"status": "refuse"}))
     * @Extra\Route("/us/{id}/accept", name="story_accept", defaults={"status": "accept"}))
     * @Extra\Route("/us/{id}/block", name="story_block", defaults={"status": "block"}))
     * @Extra\Route("/us/{id}/deblock", name="story_deblock", defaults={"status": "deblock"}))
     *
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     * @param                                        $status
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateStatusAction(UserStory $story, $status)
    {
        switch ($status) {
            case 'plan':
                $story->plan();
                break;
            case 'unplan':
                $story->unplan();
                break;
            case 'start':
                $story->start($this->getUser());
                break;
            case 'deliver':
                $story->deliver();
                //mark all issues as solved
                $this->getDoctrine()->getRepository('MiniTeamScrumBundle:Issue')->solveIssuesOnStory($story);
                break;
            case 'refuse':
                $story->refuse();
                break;
            case 'accept':
                $story->accept();
                break;
            case 'block':
                $story->block();
                break;
            case 'deblock':
                $story->deblock();
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

    /**
     * @Extra\Route("/us/{id}/delete", name="story_delete")
     *
     * @param \MiniTeam\ScrumBundle\Entity\UserStory $story
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(UserStory $story)
    {
        $project = $story->getProject();
        $status  = $story->getStatus();

        $em = $this->getDoctrine()->getManager();
        $em->remove($story);
        $em->flush();

        return $this->redirect(
            $this->generateUrl(
                'story_list',
                array(
                    'status' => $status,
                    'project' => $project,
                )
            )
        );
    }
}
