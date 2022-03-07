<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\Exception;

use Payjp\Error\Base;

class ApiErrorException extends \RuntimeException implements PayjpBundleException
{
    private string $className;

    private string $method;

    private array $args;

    private string $payjpCode;


    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    /**
     * @return string
     */
    public function getPayjpCode(): string
    {
        return $this->payjpCode;
    }

    final public static function newException(string $className, string $method, array $args, Base $previous): self
    {
        $e = new self($previous->getMessage(), (int) $previous->getCode(), $previous);
        $e->className = $className;
        $e->method = $method;
        $e->args = $args;
        $e->payjpCode = (string) $previous->getCode();

        return $e;
    }
}
