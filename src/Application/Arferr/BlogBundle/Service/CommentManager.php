<?php

namespace Application\Arferr\BlogBundle\Service;

use Application\Arferr\BlogBundle\Event\NewCommentEvent;
use Application\Arferr\BlogBundle\Repository\CommentRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Application\Arferr\BlogBundle\Entity\Comment;

/**
 * Class CommentManager
 * @package Application\Arferr\BlogBundle
 */
class CommentManager {
    /**
     * @var EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EventDispatcher $eventDispatcher
     * @param EntityManager $em
     * @param CommentRepository $repository
     */
    public function __construct($eventDispatcher, $em) {
        $this->setEventDispatcher($eventDispatcher);
        $this->setEm($em);
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $eventDispatcher
     */
    public function setEventDispatcher($eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * @return Comment
     */
    public function createComment()
    {
        return new Comment();
    }

    /**
     * Dispatches new comment event.
     *
     * @param $username
     * @param $content
     * @param $postId
     */
    public function dispatchNewCommentEvent($username, $content, $postId) {
        $event = new NewCommentEvent();
        $event->setAuthorUsername($username);
        $event->setContent($content);
        $event->setPostId($postId);

        $this->getEventDispatcher()->dispatch('application_arferr_blog.event.new_comment', $event);
    }

    /**
     * Persists or updates comment entity.
     *
     * @param Comment $comment
     * @param bool $andFlush
     */
    public function updateComment(Comment $comment, $andFlush = true)
    {
        $this->getEm()->persist($comment);
        if ($andFlush) {
            $this->getEm()->flush();
        }
    }
}