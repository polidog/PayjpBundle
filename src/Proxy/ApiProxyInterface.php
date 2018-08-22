<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Proxy;

interface ApiProxyInterface
{
    public function execute(string $className, string $method, array $args);
}
