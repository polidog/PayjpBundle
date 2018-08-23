<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\Proxy;

use Payjp\ApiResource;
use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\Proxy\ApiProxyInterface;
use Polidog\PayjpBundle\Proxy\CheckApiResourceClass;
use Polidog\PayjpBundle\Proxy\ClassFinder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ClassFinderTest extends TestCase
{
    private $eventDispatcher;

    private $apiProxy;

    private $checkApiResourceClass;

    public function setUp(): void
    {
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->apiProxy = $this->prophesize(ApiProxyInterface::class);
        $this->checkApiResourceClass = $this->prophesize(CheckApiResourceClass::class);
    }

    public function test_call(): void
    {
        $property = 'Card';
        $method = 'create';
        $className = "\\Payjp\\$property";

        $data = [
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => '02',
                'exp_year' => '2020',
            ],
            'amount' => 3500,
            'currency' => 'jpy',
        ];

        $this->apiProxy->execute("\\Payjp\\$property", $method, $data)
            ->willReturn(new DummyApiResource());

        $this->checkApiResourceClass->check($className)
            ->willReturn(true);

        $methodProxy = new ClassFinder($this->eventDispatcher->reveal(), $this->apiProxy->reveal(), $this->checkApiResourceClass->reveal());
        $methodProxy->execute($property, $method, $data);

        $this->apiProxy->execute("\\Payjp\\$property", $method, $data)
            ->shouldHaveBeenCalled();
    }
}

class DummyApiResource extends ApiResource
{
}
