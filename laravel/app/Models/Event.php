<?php declare(strict_types=1);

namespace App\Models;

use App\Enums\EventTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Event
 *
 * @property int $user_id
 * @property string $event_type
 * @property array $event_data
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 */
class Event extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'event_type',
        'event_data',
        'description',
        'created_at',
    ];

    protected $casts = [
        'event_type' => EventTypeEnum::class,
        'event_data' => 'array',
    ];
}
