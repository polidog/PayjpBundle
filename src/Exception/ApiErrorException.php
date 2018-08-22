<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Exception;

use Payjp\Error\Base;

class ApiErrorException extends \RuntimeException implements PayjpBundleException
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $args;

    /**
     * ApiErrorException constructor.
     *
     * @param string $className
     * @param string $method
     * @param array  $args
     */
    public function __construct($className, $method, array $args, Base $previous)
    {
        $this->className = $className;
        $this->method = $method;
        $this->args = $args;
        parent::__construct($previous->getMessage(), $previous->getCode(), $previous);
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}
