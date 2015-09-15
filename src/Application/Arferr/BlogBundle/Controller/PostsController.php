<?php

namespace Application\Arferr\BlogBundle\Controller;

use Application\Arferr\BlogBundle\Entity\Comment;
use Application\Arferr\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostsController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        //there must be a pagination, but there isn't production code
        $posts = $this->getDoctrine()->getRepository('ApplicationArferrBlogBundle:Post')->findAllWithAuthors();

        return $this->render('ApplicationArferrBlogBundle:Posts:index.html.twig', array('posts' => $posts));
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function viewAction($id) {
        $commentManager = $this->get('application_arferr_blog.service.comment_manager');
        $post = $this->getDoctrine()->getRepository('ApplicationArferrBlogBundle:Post')->findOneByIdWithComments($id);

        if ($post == null) {
            throw $this->createNotFoundException('There is no post with such id!');
        }

        $commentForm = $this->createForm(new CommentType(), $commentManager->createComment(), array('action' => $this->generateUrl('comment_add', array('postId'=>$id))));

        return $this->render('ApplicationArferrBlogBundle:Posts:view.html.twig', array('post'=>$post, 'commentForm'=>$commentForm->createView()));
    }
}
