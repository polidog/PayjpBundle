<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

class CheckApiResourceClass
{
    public function __construct(private string $apiResourceClassName)
    {
    }

    final public function check(string $className): bool
    {
        foreach (class_parents($className) as $parentClassName) {
            if ($this->apiResourceClassName === $parentClassName) {
                return true;
            }
        }

        return false;
    }
}
