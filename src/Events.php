<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle;

final class Events
{
    public const REQUEST = 'polidog_payjp.request';

    public const RESPONSE = 'polidog_payjp.response';

    public const WEB_HOOK = 'polidog_payjp.web_hook';
}
