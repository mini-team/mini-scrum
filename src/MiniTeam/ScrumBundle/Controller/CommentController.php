<?php

namespace MiniTeam\ScrumBundle\Controller;

use MiniTeam\ScrumBundle\Entity\UserStory;
use MiniTeam\ScrumBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use MiniTeam\ScrumBundle\Entity\StoryNotification;

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
            $project = $comment->getStory()->getProject();
            $story = $comment->getStory();
            $author = $comment->getAuthor();

            $em = $this->getDoctrine()->getManager();

            //add comment
            $em->persist($comment);

            //add story notif to all users with negative role

            if( $author->getRole($project) == \MiniTeam\ScrumBundle\Entity\Membership::PRODUCT_OWNER) {
                foreach( $project->getDevelopers() as $dev){
                    $notification = new StoryNotification();
                    $notification->setRecipient($dev);
                    $notification->setStory($story);
                    $em->persist($notification);
                }
            }else if ($author->getRole($project) == \MiniTeam\ScrumBundle\Entity\Membership::DEVELOPER) {
                $notification = new StoryNotification();
                $notification->setRecipient($project->getProductOwner());
                $notification->setStory($story);
                $em->persist($notification);
            }

            $em->flush();

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
