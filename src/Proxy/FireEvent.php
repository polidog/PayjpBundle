<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Proxy;

use Payjp\ApiResource;
use Polidog\PayjpBundle\Event\RequestEvent;
use Polidog\PayjpBundle\Event\ResponseEvent;
use Polidog\PayjpBundle\Events;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FireEvent implements ApiProxyInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var ApiProxyInterface
     */
    private $apiProxy;

    /**
     * FireEvent constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ApiProxyInterface        $apiProxy
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, ApiProxyInterface $apiProxy)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->apiProxy = $apiProxy;
    }

    /**
     * @param string $className
     * @param string $method
     * @param array  $args
     */
    public function execute(string $className, string $method, array $args)
    {
        $this->fireRequestEvent($className, $method, $args);
        $result = $this->apiProxy->execute($className, $method, $args);
        $this->fireResponseEvent($className, $method, $args, $result);

        return $result;
    }

    private function fireRequestEvent(string $className, string  $method, array $args): void
    {
        $requestEvent = new RequestEvent($className, $method, $args);
        $this->eventDispatcher->dispatch(Events::REQUEST, $requestEvent);
    }

    private function fireResponseEvent(string $className, string  $method, array $args, ApiResource $result): void
    {
        $responseEvent = new ResponseEvent($className, $method, $args, $result);
        $this->eventDispatcher->dispatch(Events::RESPONSE, $responseEvent);
    }
}
