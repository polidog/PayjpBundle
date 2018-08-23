<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

interface ApiDecoratorInterface
{
    public function execute(string $className, string $method, array $args);
}
