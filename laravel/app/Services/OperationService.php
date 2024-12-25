<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Events\CreateEventDto;
use App\DTO\Operations\CreateOperationDto;
use App\DTO\Operations\GetOperationsDto;
use App\Enums\EventTypeEnum;
use App\Models\Event;
use App\Models\User;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

readonly class OperationService
{
    public function __construct(
        private EventRepositoryInterface $eventRepository
    )
    {
    }

    /**
     * @param GetOperationsDto $getOperationsDto
     * @return LengthAwarePaginator
     */
    public function getUserOperations(GetOperationsDto $getOperationsDto): LengthAwarePaginator
    {
        $getOperationsDto->event_types = [
            EventTypeEnum::BalanceCredited->value,
            EventTypeEnum::BalanceDebited->value
        ];

        return $this->eventRepository->getByUser($getOperationsDto);
    }

    /**
     * @param CreateOperationDto $createOperationDto
     * @return Event
     * @throws \Exception
     */
    public function processOperation(CreateOperationDto $createOperationDto): Event
    {
        $this->validateOperation($createOperationDto);

        return DB::transaction(function () use ($createOperationDto) {
            $user = $createOperationDto->user;

            $this->updateUserBalance($user, $createOperationDto->event_data['amount'], $createOperationDto->event_type);

            $user->balance->save();

            $createEventDto = CreateEventDto::from($createOperationDto->toArray());
            $createEventDto->user_id = $user->id;
            $createEventDto->event_data['balance_after'] = $user->balance->balance;

            return $this->eventRepository->create($createEventDto);
        });
    }

    /**
     * @param CreateOperationDto $dto
     * @return void
     * @throws \Exception
     */
    private function validateOperation(CreateOperationDto $dto): void
    {
        if ($dto->event_type === EventTypeEnum::BalanceDebited->value &&
            $dto->user->balance->balance < $dto->event_data['amount']) {
            throw new \Exception("Not enough money to be debited. Current balance: {$dto->user->balance->balance}");
        }

        if (!in_array($dto->event_type, [EventTypeEnum::BalanceDebited->value, EventTypeEnum::BalanceCredited->value])) {
            throw new \InvalidArgumentException("Wrong operation! Just use balance_credited or balance_debited");
        }
    }

    /**
     * @param User $user
     * @param float $amount
     * @param string $eventType
     * @return void
     */
    private function updateUserBalance(User $user, float $amount, string $eventType): void
    {
        if ($eventType === EventTypeEnum::BalanceDebited->value) {
            $user->balance->balance -= $amount;
        } elseif ($eventType === EventTypeEnum::BalanceCredited->value) {
            $user->balance->balance += $amount;
        }
    }
}
