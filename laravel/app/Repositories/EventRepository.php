<?php declare(strict_types=1);

namespace App\Repositories;

use App\DTO\Events\CreateEventDto;
use App\DTO\Operations\GetOperationsDto;
use App\Models\Event;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryInterface
{
    public function getByUser(GetOperationsDto $getOperationsDto): LengthAwarePaginator
    {
        return Event::where('user_id', $getOperationsDto->user_id)
                    ->whereIn('event_type', $getOperationsDto->event_types)
                    ->where('description', 'LIKE', "%$getOperationsDto->search%")
                    ->orderByDesc('created_at')
                    ->paginate($getOperationsDto->limit);
    }

    public function create(CreateEventDto $createEventDto): Event
    {
        return Event::create($createEventDto->toArray());
    }
}
