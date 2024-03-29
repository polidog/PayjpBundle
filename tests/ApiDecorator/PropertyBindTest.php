<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\ApiDecorator;

use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\ApiDecorator\ApiDecoratorInterface;
use Polidog\PayjpBundle\ApiDecorator\PropertyBind;
use Prophecy\PhpUnit\ProphecyTrait;

class PropertyBindTest extends TestCase
{
    use ProphecyTrait;

    public function testCall(): void
    {
        $apiProxy = $this->prophesize(ApiDecoratorInterface::class);
        $property = 'abc';
        $param = 'world';

        $propertyBind = new PropertyBind($apiProxy->reveal(), $property);
        $propertyBind->hello($param);

        $apiProxy->execute($property, 'hello', [$param])
            ->shouldHaveBeenCalled();
    }
}
