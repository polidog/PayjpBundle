<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Payjp\Error\Base;
use Payjp\Payjp;
use Polidog\PayjpBundle\Exception\ApiErrorException;

class CallApi implements ApiDecoratorInterface
{
    public function __construct(private string $apiKey)
    {
    }

    /**
     * @throws ApiErrorException
     */
    final public function execute(string $className, string $method, array $args): mixed
    {
        Payjp::setApiKey($this->apiKey);
        try {
            return call_user_func_array([$className, $method], $args);
        } catch (Base $apiError) {
            throw ApiErrorException::newException($className, $method, $args, $apiError);
        }
    }
}
