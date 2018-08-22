<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\Proxy\CheckApiResourceClass;

class CheckApiResourceClassTest extends TestCase
{
    /**
     * @dataProvider dp_classNames
     *
     * @param $className
     * @param $expect
     */
    public function testCheckPayjpClass($className, $expect): void
    {
        $checkClass = new CheckApiResourceClass('Payjp\\ApiResource');
        $actual = $checkClass->check($className);
        $this->assertSame($expect, $actual);
    }

    public function dp_classNames()
    {
        return [
            ['\\Payjp\\Account', true],
            ['\\Payjp\\AttachedObject', false],
            ['\\Payjp\\Card', true],
        ];
    }
}
