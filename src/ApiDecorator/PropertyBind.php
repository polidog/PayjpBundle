<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

class PropertyBind
{
    public function __construct(private ApiDecoratorInterface $ApiProxy, private string $property)
    {
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->ApiProxy->execute($this->property, $name, $arguments);
    }
}
