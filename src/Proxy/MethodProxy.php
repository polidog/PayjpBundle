<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Proxy;

use Payjp\ApiResource;
use Polidog\PayjpBundle\Event\RequestEvent;
use Polidog\PayjpBundle\Event\ResponseEvent;
use Polidog\PayjpBundle\Events;
use Polidog\PayjpBundle\Exception\ApiErrorException;
use Polidog\PayjpBundle\Exception\ClassNotFoundException;
use Polidog\PayjpBundle\Exception\NoApiResourceClassException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MethodProxy implements ApiProxyInterface
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
     * @var CheckApiResourceClass
     */
    private $checkApiResourceClass;

    /**
     * MethodProxy constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param ApiProxyInterface        $apiProxy
     * @param CheckApiResourceClass    $checkApiResourceClass
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, ApiProxyInterface $apiProxy, CheckApiResourceClass $checkApiResourceClass)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->apiProxy = $apiProxy;
        $this->checkApiResourceClass = $checkApiResourceClass;
    }

    /**
     * @param string $property
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     *
     * @throws ClassNotFoundException
     * @throws ApiErrorException
     */
    public function execute(string $property, string $method, array $args)
    {
        $className = sprintf('\\Payjp\\%s', ucfirst($property));

        if (false === class_exists($className)) {
            throw new ClassNotFoundException('no exist class: '.$className);
        }

        if (false === $this->checkApiResourceClass->check($className)) {
            throw new NoApiResourceClassException("$className is no Payjp\ApiResource extends object.");
        }

        $this->fireRequestEvent($className, $method, $args);
        $result = $this->apiProxy->execute($className, $method, $args);
        $this->fireResponseEvent($className, $method, $args, $result);

        return $result;
    }

    /**
     * @param string $className
     * @param string $method
     * @param array  $args
     */
    private function fireRequestEvent(string $className, string  $method, array $args): void
    {
        $requestEvent = new RequestEvent($className, $method, $args);
        $this->eventDispatcher->dispatch(Events::REQUEST, $requestEvent);
    }

    /**
     * @param string $className
     * @param string $method
     * @param array  $args
     * @param array  $result
     */
    private function fireResponseEvent(string $className, string  $method, array $args, ApiResource $result): void
    {
        $responseEvent = new ResponseEvent($className, $method, $args, $result);
        $this->eventDispatcher->dispatch(Events::RESPONSE, $responseEvent);
    }
}
