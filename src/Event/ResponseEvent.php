<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Event;

use Payjp\ApiResource;
use Symfony\Contracts\EventDispatcher\Event;

class ResponseEvent extends Event
{
    public function __construct(private string $className, private string $method, private array $args, private ApiResource $response)
    {
    }

    final public function getClassName(): string
    {
        return $this->className;
    }

    final public function getMethod(): string
    {
        return $this->method;
    }

    final public function getArgs(): array
    {
        return $this->args;
    }

    public function getResponse(): ApiResource
    {
        return $this->response;
    }
}
