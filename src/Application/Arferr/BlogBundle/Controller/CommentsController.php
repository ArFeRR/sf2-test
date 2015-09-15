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
    /**
     * @param $postId
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAddAction($postId, Request $request) {
        if($request->isXmlHttpRequest() && $request->isMethod('POST')) { //for only ajax sent post requests to be processed
            $commentManager = $this->get('application_arferr_blog.service.comment_manager');
            $post = $this->getDoctrine()->getRepository('ApplicationArferrBlogBundle:Post')->find($postId);
            /** @var Comment $comment */
            $comment = $commentManager->createComment();
            $form = $this->createForm(new CommentType(), $comment);
            $author = $this->getUser();

            $form->handleRequest($request);

            if ($form->isValid()) {
                $comment->setPost($post);
                $comment->setAuthor($author);
                $commentManager->updateComment($comment, true);
                //dispatching the new comment event, which will lead to the notification of the external systems
                $commentManager->dispatchNewCommentEvent($author->getUsername(), $comment->getContent(), $postId);

                $view = $this->renderView('ApplicationArferrBlogBundle:Posts:_comment.html.twig', array('comment'=>$comment));
                $response = array('status' => 'ok', 'code' => 200, 'message' => 'Your comment was successfully added.', 'html'=>$view);
            } else {
                $response = array('status' => 'invalidForm', 'code' => 422, 'message' => $form->getErrorsAsString());
            }
        } else {
            $response = array('status' => 'wrongRequest', 'code' => 400, 'message' => 'Wrong request. Must be ajax.');
        }

        return new JsonResponse($response, $response['code']);
    }
}