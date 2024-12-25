<?php declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\DTO\Events\CreateEventDto;
use App\DTO\Operations\GetOperationsDto;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EventRepositoryInterface
{
    /**
     * Get events by user id
     *
     * @param GetOperationsDto $getOperationsDto
     * @return LengthAwarePaginator
     */
    public function getByUser(GetOperationsDto $getOperationsDto): LengthAwarePaginator;

    /**
     * Create an event
     *
     * @param CreateEventDto $createEventDto
     * @return Event
     */
    public function create(CreateEventDto $createEventDto): Event;
}
