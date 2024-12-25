<?php declare(strict_types=1);

namespace App\DTO\Operations;

use Spatie\LaravelData\Data;

class GetOperationsDto extends Data
{
    public int $user_id;
    public ?int $limit;
    public ?array $event_types;
    public ?string $search;

    public function __construct()
    {
    }
}
