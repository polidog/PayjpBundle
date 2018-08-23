<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\Proxy\ApiProxyInterface;
use Polidog\PayjpBundle\Proxy\PropertyBind;

class PropertyBindTest extends TestCase
{
    public function testCall(): void
    {
        $apiProxy = $this->prophesize(ApiProxyInterface::class);
        $property = 'abc';
        $param = 'world';

        $propertyBind = new PropertyBind($apiProxy->reveal(), $property);
        $propertyBind->hello($param);

        $apiProxy->execute($property, 'hello', [$param])
            ->shouldHaveBeenCalled();
    }
}
