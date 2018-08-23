<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

class CheckApiResourceClass
{
    private $apiResourceClassName;

    /**
     * CheckApiResourceClass constructor.
     *
     * @param string $apiResourceClassName
     */
    public function __construct(string $apiResourceClassName)
    {
        $this->apiResourceClassName = $apiResourceClassName;
    }

    public function check(string $className): bool
    {
        foreach (class_parents($className) as $parentClassName) {
            if ($this->apiResourceClassName === $parentClassName) {
                return true;
            }
        }

        return false;
    }
}
