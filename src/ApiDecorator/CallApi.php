<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle\ApiDecorator;

use Payjp\Error\Base;
use Payjp\Payjp;
use Polidog\PayjpBundle\Exception\ApiErrorException;

class CallApi implements ApiDecoratorInterface
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * CallApi constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $className
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     *
     * @throws ApiErrorException
     */
    public function execute(string $className, string $method, array $args)
    {
        Payjp::setApiKey($this->apiKey);
        try {
            return call_user_func_array([$className, $method], $args);
        } catch (Base $apiError) {
            throw new ApiErrorException($className, $method, $args, $apiError);
        }
    }
}
