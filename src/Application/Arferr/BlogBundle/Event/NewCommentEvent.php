<?php
namespace Application\Arferr\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewCommentEvent contains the comment data which the external systems should be notified about.
 * @package Application\Arferr\BlogBundle\Event
 */
class NewCommentEvent extends Event
{
    /**
     * @var string
     */
    protected $authorUsername;

    /**
     * @var int
     */
    protected $postId;

    /**
     * @var string
     */
    protected $content;

    /**
     * @param int $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    /**
     * @return int
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $authorUsername
     */
    public function setAuthorUsername($authorUsername)
    {
        $this->authorUsername = $authorUsername;
    }

    /**
     * @return string
     */
    public function getAuthorUsername()
    {
        return $this->authorUsername;
    }

    /**
     * @return array
     */
    public function toArray() {
        return get_object_vars($this);
    }
}