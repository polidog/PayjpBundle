<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle;

use Payjp\Account;
use Payjp\Card;
use Payjp\Charge;
use Payjp\Customer;
use Payjp\Event;
use Payjp\Subscription;
use Payjp\Token;
use Polidog\PayjpBundle\Proxy\ApiProxyInterface;
use Polidog\PayjpBundle\Proxy\PropertyBind;

/**
 * Class Payjp.
 *
 * @property Customer     $customer
 * @property Card         $card
 * @property Charge       $charge
 * @property Token        $token
 * @property Account      $account
 * @property Event        $event
 * @property Subscription $subscription
 */
class Payjp
{
    /**
     * @var ApiProxyInterface
     */
    private $apiProxy;

    /**
     * Payjp constructor.
     *
     * @param ApiProxyInterface $apiProxy
     */
    public function __construct(ApiProxyInterface $apiProxy)
    {
        $this->apiProxy = $apiProxy;
    }

    public function __get($name)
    {
        return new PropertyBind($this->apiProxy, $name);
    }

    public function __set($name, $value): void
    {
        throw new \LogicException();
    }

    public function __isset($name): void
    {
        throw new \LogicException();
    }
}
