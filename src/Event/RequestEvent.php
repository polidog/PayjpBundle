<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class RequestEvent extends Event
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
     * RequestEvent constructor.
     *
     * @param string $className
     * @param string $method
     * @param string $args
     */
    public function __construct(string $className, string $method, array $args)
    {
        $this->className = $className;
        $this->method = $method;
        $this->args = $args;
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
}
