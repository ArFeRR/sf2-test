<?php

namespace Application\Arferr\BlogBundle\EventListener;

use Application\Arferr\BlogBundle\Event\NewCommentEvent;
use Application\Arferr\BlogBundle\Event\NewPostEvent;

/**
 * Class CrmNotifier performs notification of the external crm system
 * @package Application\Arferr\BlogBundle\EventListener
 */
class CrmNotifier extends AbstractNotifier {

    /**
     * @param NewCommentEvent $event
     */
    public function onNewComment(NewCommentEvent $event) {
        //echo 'crmNotifier, onNewComment';
        $this->processRequest($event->toArray());
    }

    /**
     * @param NewPostEvent $event
     */
    public function onNewPost(NewPostEvent $event) {
        //echo 'crmNotifier, onNewPost';
        $this->processRequest($event->toArray());
    }
}