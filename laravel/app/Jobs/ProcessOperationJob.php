<?php declare(strict_types=1);

namespace App\Jobs;

use App\DTO\Operations\CreateOperationDto;
use App\Services\OperationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessOperationJob implements ShouldQueue
{
    use Queueable;

    private CreateOperationDto $operationDto;

    /**
     * Create a new job instance.
     */
    public function __construct(CreateOperationDto $operationDto)
    {
        $this->operationDto = $operationDto;
    }

    /**
     * Execute the job.
     * @throws \Exception
     */
    public function handle(OperationService $operationService): void
    {
        $operationService->processOperation($this->operationDto);
    }
}
