<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\ApiDecorator;

use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\ApiDecorator\CallApi;

class CallApiTest extends TestCase
{
    final public function testExecute(): void
    {
        $dummyApiKey = 'akekekeke';
        $callApi = new CallApi($dummyApiKey);
        $result = $callApi->execute(DummyApiClass::class, 'call', ['hello']);
        $this->assertSame('call-DummyApiClass hello', $result);
    }
}

class DummyApiClass
{
    public static function call(string $a): string
    {
        return 'call-DummyApiClass '.$a;
    }
}
