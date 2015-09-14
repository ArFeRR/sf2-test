<?php

namespace Application\Arferr\BlogBundle\Controller;

use Application\Arferr\BlogBundle\Entity\Comment;
use Application\Arferr\BlogBundle\Event\NewCommentEvent;
use Application\Arferr\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends Controller
{
    public function ajaxAddAction($post_id, Request $request) {
        if($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('ApplicationArferrBlogBundle:Post')->find($post_id);
            $comment = new Comment();
            $form = $this->createForm(new CommentType(), $comment);
            $author = $this->getUser();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $comment->setPost($post);
                $comment->setAuthor($author);
                try {
                    $em->persist($comment);
                    $em->flush();

                    //dispatching the new comment event, which will lead to the notification of the external systems
                    $event = new NewCommentEvent();
                    $event->setAuthorUsername($author->getUsername());
                    $event->setContent($comment->getContent());
                    $event->setPostId($post_id);

                    $dispatcher = $this->get('event_dispatcher');
                    $dispatcher->dispatch('application_arferr_blog.event.new_comment', $event);

                    $view = $this->renderView('ApplicationArferrBlogBundle:Posts:_comment.html.twig', array('comment'=>$comment));
                    $response = array('status' => 'ok', 'message' => 'Your comment was successfully added.', 'html'=>$view);
                } catch (\Exception $e) {
                    $response = array('status'=> 'error', 'message' => $e->getMessage());
                }
            } else {
                $response = array('status' => 'invalidForm', 'message' => $form->getErrorsAsString());
            }
        } else {
            $response = array('status' => 'wrongRequest', 'message' => 'Wrong request. Must be ajax.');
        }

        return new JsonResponse($response);
    }
}