<?php

namespace Application\Arferr\BlogBundle\Admin;

use Application\Arferr\BlogBundle\Entity\Post;
use Application\Arferr\BlogBundle\Event\NewPostEvent;
use Application\Sonata\UserBundle\Entity\User;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class PostAdmin extends Admin
{
    /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer (\Symfony\Component\DependencyInjection\ContainerInterface $container) {
        $this->container = $container;
    }

    public function getContainer() {
        return $this->container;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
            ->add('content')
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('author')
            ->add('title')
            ->add('content')
            ->add('createdAt')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title')
            ->add('content')
            ->add('author')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('content')
            ->add('createdAt')
        ;
    }

    /**
     * @param Post $post
     * @return mixed|void
     */
    public function postPersist($post) {
        $author = $post->getAuthor();
        $username = 'not defined';
        if($author instanceOf User) {
            $username = $author->getUsername();
        }

        $event = new NewPostEvent();
        $event->setAuthorUsername($username);
        $event->setContent($post->getContent());

        $dispatcher = $this->getContainer()->get('event_dispatcher');
        $dispatcher->dispatch('application_arferr_blog.event.new_post', $event);
    }
}
