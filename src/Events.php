<?php

declare(strict_types=1);

namespace Polidog\PayjpBundle;

final class Events
{
    const REQUEST = 'polidog_payjp.request';

    const RESPONSE = 'polidog_payjp.response';

    const WEB_HOOK = 'polidog_payjp.web_hook';
}
