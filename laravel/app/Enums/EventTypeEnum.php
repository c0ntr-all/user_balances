<?php declare(strict_types=1);

namespace App\Enums;

use App\Enums\Traits\Arrayable;

enum EventTypeEnum: string
{
    use Arrayable;

    case BalanceCredited = 'balance_credited';
    case BalanceDebited = 'balance_debited';
    case UserRegistered = 'user_registered';
}
