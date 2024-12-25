<?php declare(strict_types=1);

namespace App\DTO\Events;

use Spatie\LaravelData\Data;

class CreateEventDto extends Data
{
    public int $user_id;
    public string $event_type;
    public array $event_data;
    public ?string $description = null;

    public function __construct()
    {
    }
}
