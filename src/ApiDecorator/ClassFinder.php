<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Polidog\PayjpBundle\Exception\ApiErrorException;
use Polidog\PayjpBundle\Exception\ClassNotFoundException;
use Polidog\PayjpBundle\Exception\NoApiResourceClassException;

class ClassFinder implements ApiDecoratorInterface
{
    /**
     * MethodProxy constructor.
     *
     * @param ApiDecoratorInterface $api
     * @param CheckApiResourceClass $checkApiResourceClass
     */
    public function __construct(private ApiDecoratorInterface $api, private CheckApiResourceClass $checkApiResourceClass)
    {
    }

    /**
     * @throws ClassNotFoundException
     * @throws ApiErrorException
     */
    public function execute(string $className, string $method, array $args): mixed
    {
        $payJpClassName = sprintf('\\Payjp\\%s', ucfirst($className));

        if (false === class_exists($payJpClassName)) {
            throw new ClassNotFoundException('no exist class: '.$payJpClassName);
        }

        if (false === $this->checkApiResourceClass->check($payJpClassName)) {
            throw new NoApiResourceClassException("$payJpClassName is no Payjp\ApiResource extends object.");
        }

        return $this->api->execute($payJpClassName, $method, $args);
    }
}
