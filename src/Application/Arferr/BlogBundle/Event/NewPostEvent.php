<?php
namespace Application\Arferr\BlogBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class NewPostEvent contains the post data which the external systems should be notified about.
 * @package Application\Arferr\BlogBundle\Event
 */
class NewPostEvent extends Event
{
    /**
     * @var string
     */
    protected $authorUsername;

    /**
     * @var string
     */
    protected $content;

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