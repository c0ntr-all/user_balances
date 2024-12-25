<?php declare(strict_types=1);

namespace App\DTO\Operations;

use App\Enums\EventTypeEnum;
use App\Models\User;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Data;

class CreateOperationDto extends Data
{
    public User $user;
    #[In([EventTypeEnum::BalanceDebited, EventTypeEnum::BalanceCredited])]
    public string $event_type;
    public array $event_data;
    public ?string $description = null;

    public function __construct()
    {
    }
}
