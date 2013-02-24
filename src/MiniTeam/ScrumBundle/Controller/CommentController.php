<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Comment;
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
class CommentController extends Controller
{
    /**
     * @Extra\Route("/comment/new", name="comment_new")
     * @Extra\ParamConverter("story", options={"mapping": {"story": "id"}})
     * @Extra\Template()
     */
    public function newAction(UserStory $story, Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $comment = new Comment();
        $comment->setAuthor($user);
        $comment->setStory($story);

        $commentForm = $this->createFormBuilder($comment)
                            ->add('content', 'text')
                            ->getForm();

        if ($request->isMethod('post')) {
            $response = $this->processCommentForm($request, $commentForm);

            if ($response instanceof RedirectResponse) {
                return $response;
            }
        }

        $this->redirect($this->generateUrl('project_show'));
    }

    /**
     * Process the form of a Comment
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Form\Form              $form
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function processCommentForm(Request $request, Form $form)
    {
        $form->bind($request);

        if ($form->isValid()) {
            $comment = $form->getData();

            //add comment
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //add story notification for this comment
            $this->get('story_notifier')->addStoryNotificationForComment($comment);

            return $this->redirect(
                $this->generateUrl(
                    'story_show',
                    array(
                        'project' => $comment->getStory()->getProject()->getSlug(),
                        'id' => $comment->getStory()->getId()
                    )
                )
            );
        }
    }
}
