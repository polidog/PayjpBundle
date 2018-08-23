<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Polidog\PayjpBundle\Exception\ApiErrorException;
use Polidog\PayjpBundle\Exception\ClassNotFoundException;
use Polidog\PayjpBundle\Exception\NoApiResourceClassException;

class ClassFinder implements ApiDecoratorInterface
{
    /**
     * @var ApiDecoratorInterface
     */
    private $apiProxy;

    /**
     * @var CheckApiResourceClass
     */
    private $checkApiResourceClass;

    /**
     * MethodProxy constructor.
     *
     * @param ApiDecoratorInterface $apiProxy
     * @param CheckApiResourceClass $checkApiResourceClass
     */
    public function __construct(ApiDecoratorInterface $apiProxy, CheckApiResourceClass $checkApiResourceClass)
    {
        $this->apiProxy = $apiProxy;
        $this->checkApiResourceClass = $checkApiResourceClass;
    }

    /**
     * @param string $property
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     *
     * @throws ClassNotFoundException
     * @throws ApiErrorException
     */
    public function execute(string $property, string $method, array $args)
    {
        $className = sprintf('\\Payjp\\%s', ucfirst($property));

        if (false === class_exists($className)) {
            throw new ClassNotFoundException('no exist class: '.$className);
        }

        if (false === $this->checkApiResourceClass->check($className)) {
            throw new NoApiResourceClassException("$className is no Payjp\ApiResource extends object.");
        }

        return $this->apiProxy->execute($className, $method, $args);
    }
}
