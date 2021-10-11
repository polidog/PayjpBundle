<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\ApiDecorator;

use Payjp\Account;
use Payjp\AttachedObject;
use Payjp\Card;
use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\ApiDecorator\CheckApiResourceClass;

class CheckApiResourceClassTest extends TestCase
{
    /**
     * @dataProvider dp_classNames
     */
    final public function testCheckPayjpClass(string $className, bool $expect): void
    {
        $checkClass = new CheckApiResourceClass('Payjp\\ApiResource');
        $actual = $checkClass->check($className);
        $this->assertSame($expect, $actual);
    }

    public function dp_classNames()
    {
        return [
            [Account::class, true],
            [AttachedObject::class, false],
            [Card::class, true],
        ];
    }
}
