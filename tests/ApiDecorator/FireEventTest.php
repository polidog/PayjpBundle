<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\ApiDecorator;

use Payjp\ApiResource;
use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\ApiDecorator\ApiDecoratorInterface;
use Polidog\PayjpBundle\ApiDecorator\FireEvent;
use Polidog\PayjpBundle\Event\RequestEvent;
use Polidog\PayjpBundle\Event\ResponseEvent;
use Polidog\PayjpBundle\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class FireEventTest extends TestCase
{
    private $eventDispatcher;
    private $apiProxy;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->apiProxy = $this->prophesize(ApiDecoratorInterface::class);
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
