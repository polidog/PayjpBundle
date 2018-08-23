<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Tests\Proxy;

use PHPUnit\Framework\TestCase;
use Polidog\PayjpBundle\Proxy\CallApi;

class CallApiTest extends TestCase
{
    public function testExecute(): void
    {
        $dummyApiKey = 'akekekeke';
        $callApi = new CallApi($dummyApiKey);
        $result = $callApi->execute(DummyApiClass::class, 'call', ['hello']);
        $this->assertSame('call-DummyApiClass hello', $result);
    }
}

class DummyApiClass
{
    public static function call(string $a)
    {
        return 'call-DummyApiClass '.$a;
    }
}
