<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Polidog\PayjpBundle\Exception\ApiErrorException;
use Polidog\PayjpBundle\Exception\ClassNotFoundException;

class PropertyBind
{
    /**
     * @var ApiDecoratorInterface
     */
    private $ApiProxy;

    /**
     * @var string
     */
    private $property;

    /**
     * PropertyBind constructor.
     *
     * @param ApiDecoratorInterface $ApiProxy
     * @param string                $property
     */
    public function __construct(ApiDecoratorInterface $ApiProxy, string $property)
    {
        $this->ApiProxy = $ApiProxy;
        $this->property = $property;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     *
     * @throws ApiErrorException
     * @throws ClassNotFoundException
     */
    public function __call($name, $arguments)
    {
        return $this->ApiProxy->execute($this->property, $name, $arguments);
    }
}
