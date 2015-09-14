<?php

namespace Application\Arferr\BlogBundle\EventListener;

use Application\Arferr\BlogBundle\Event\NewCommentEvent;

/**
 * Class CrmNotifier performs notification of the external crm system
 * @package Application\Arferr\BlogBundle\EventListener
 */
abstract class AbstractNotifier {
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param $host
     * @param $path
     */
    public function __construct($host, $path) {
        $this->setHost($host);
        $this->setPath($path);
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param array $requestParams
     * @return bool
     */
    public function processRequest(array $requestParams) {
        $url = $this->host.'/'.$this->path;
        //curl blahblah
        //curl method GET/POST
        //curl send
        return true;
    }

}