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
use Polidog\PayjpBundle\ApiDecorator\ApiDecoratorInterface;
use Polidog\PayjpBundle\ApiDecorator\PropertyBind;

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
    public function __construct(private ApiDecoratorInterface $apiProxy)
    {
    }

    public function __get(string $name): PropertyBind
    {
        return new PropertyBind($this->apiProxy, $name);
    }

    public function __set(string $name, mixed $value): void
    {
        throw new \LogicException();
    }

    public function __isset(string $name): bool
    {
        throw new \LogicException();
    }
}
