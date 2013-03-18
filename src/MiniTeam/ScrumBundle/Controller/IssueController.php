<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Issue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

/**
 * @author Edouard de Labareyre <edouard@melix.net>
 *
 * @Extra\Route("/{project}/us/{story}")
 */
class IssueController extends Controller
{
    /**
     * @Extra\Route("/issue/new", name="issue_new")
     * @Extra\ParamConverter("story", options={"mapping": {"story": "id"}})
     * @Extra\Template()
     */
    public function newAction(UserStory $story, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        ///deny if not a PO or not in "to validate" status
        if ($user->isProductOwner($story->getProject()) || $story->getStatus() != 'to-validate') {
            $this->redirect($this->generateUrl('project_show'));
        }

        $issue = new Issue();
        $issue->setStory($story);

        $issueForm = $this->createFormBuilder($issue)
                          ->add('content', 'text')
                          ->getForm();

        if ($request->isMethod('post')) {
            $response = $this->processIssueForm($request, $issueForm);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        $this->redirect($this->generateUrl('project_show'));
    }

    /**
     * Process the form of an Issue
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\Form              $form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processIssueForm(Request $request, Form $form)
    {
        $form->bind($request);

        if ($form->isValid()) {
            $issue = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($issue);
            $em->flush();

            return $this->redirect(
                $this->generateUrl(
                    'story_show',
                    array(
                        'project' => $issue->getStory()->getProject()->getSlug(),
                        'id' => $issue->getStory()->getId()
                    )
                )
            );
        }
    }
}
