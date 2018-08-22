<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Event;

use Payjp\ApiResource;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $args;

    /**
     * @var ApiResource
     */
    private $response;

    /**
     * ResponseEvent constructor.
     *
     * @param string      $className
     * @param string      $method
     * @param array       $args
     * @param ApiResource $response
     */
    public function __construct($className, $method, array $args, ApiResource $response)
    {
        $this->className = $className;
        $this->method = $method;
        $this->args = $args;
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return array
     */
    public function getResponse(): ApiResource
    {
        return $this->response;
    }
}
