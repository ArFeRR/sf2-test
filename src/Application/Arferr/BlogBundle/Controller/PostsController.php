<?php

namespace Application\Arferr\BlogBundle\Controller;

use Application\Arferr\BlogBundle\Entity\Comment;
use Application\Arferr\BlogBundle\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostsController extends Controller
{
    public function indexAction()
    {
        //there must be a pagination, but there isn't production code
        $posts = $this->getDoctrine()->getRepository('ApplicationArferrBlogBundle:Post')->findAllWithAuthors();

        return $this->render('ApplicationArferrBlogBundle:Posts:index.html.twig', array('posts' => $posts));
    }

    public function viewAction($id) {
        $post = $this->getDoctrine()->getRepository('ApplicationArferrBlogBundle:Post')->findOneByIdWithComments($id);

        if ($post == null) {
            throw $this->createNotFoundException('There is no post with such id!');
        }

        $commentForm = $this->createForm(new CommentType(), new Comment(), array('action' => $this->generateUrl('comment_add', array('post_id'=>$id))));

        return $this->render('ApplicationArferrBlogBundle:Posts:view.html.twig', array('post'=>$post, 'commentForm'=>$commentForm->createView()));
    }
}
