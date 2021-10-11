<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Payjp\ApiResource;
use Polidog\PayjpBundle\Event\RequestEvent;
use Polidog\PayjpBundle\Event\ResponseEvent;
use Polidog\PayjpBundle\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FireEvent implements ApiDecoratorInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher, private ApiDecoratorInterface $api)
    {
    }

    public function execute(string $className, string $method, array $args)
    {
        $this->fireRequestEvent($className, $method, $args);
        $result = $this->api->execute($className, $method, $args);
        $this->fireResponseEvent($className, $method, $args, $result);

        return $result;
    }

    private function fireRequestEvent(string $className, string $method, array $args): void
    {
        $requestEvent = new RequestEvent($className, $method, $args);
        $this->eventDispatcher->dispatch($requestEvent, Events::REQUEST);
    }

    private function fireResponseEvent(string $className, string $method, array $args, ApiResource $result): void
    {
        $responseEvent = new ResponseEvent($className, $method, $args, $result);
        $this->eventDispatcher->dispatch($responseEvent, Events::RESPONSE);
    }
}
