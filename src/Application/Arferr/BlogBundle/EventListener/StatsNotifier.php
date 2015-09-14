<?php

namespace Application\Arferr\BlogBundle\EventListener;

use Application\Arferr\BlogBundle\Event\NewCommentEvent;
use Application\Arferr\BlogBundle\Event\NewPostEvent;

/**
 * Class StatsNotifier performs notification of the external crm system
 * @package Application\Arferr\BlogBundle\EventListener
 */
class StatsNotifier extends AbstractNotifier {
    /**
     * @param NewCommentEvent $event
     */
    public function onNewComment(NewCommentEvent $event) {
        //echo 'statsNotifier OnNewComment';
        $this->processRequest($event->toArray());
    }

    /**
     * @param NewPostEvent $event
     */
    public function onNewPost(NewPostEvent $event) {
        //echo 'statsNotifier OnNewPost';
        $this->processRequest($event->toArray());
    }
}