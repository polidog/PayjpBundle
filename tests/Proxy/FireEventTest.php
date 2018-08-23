<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\Proxy;

use Payjp\ApiResource;
use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\Event\RequestEvent;
use Polidog\PayjpBundle\Event\ResponseEvent;
use Polidog\PayjpBundle\Events;
use Polidog\PayjpBundle\Proxy\ApiProxyInterface;
use Polidog\PayjpBundle\Proxy\FireEvent;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FireEventTest extends TestCase
{
    private $eventDispatcher;
    private $apiProxy;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->apiProxy = $this->prophesize(ApiProxyInterface::class);
    }

    public function testExecute(): void
    {
        $className = 'hello';
        $method = 'world';
        $args = ['nippon'];

        $this->apiProxy->execute($className, $method, $args)
            ->willReturn(new DummyApiResource());

        $fireEvent = new FireEvent($this->eventDispatcher->reveal(), $this->apiProxy->reveal());
        $fireEvent->execute($className, $method, $args);

        $this->apiProxy->execute($className, $method, $args)
            ->shouldHaveBeenCalled();

        $this->eventDispatcher->dispatch(Events::REQUEST, Argument::type(RequestEvent::class))
            ->shouldHaveBeenCalled();

        $this->eventDispatcher->dispatch(Events::RESPONSE, Argument::type(ResponseEvent::class))
            ->shouldHaveBeenCalled();
    }
}

class DummyApiResource extends ApiResource
{
}
