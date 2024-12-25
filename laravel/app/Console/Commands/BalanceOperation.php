<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\Operations\CreateOperationDto;
use App\Jobs\ProcessOperationJob;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Console\Command;

class BalanceOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:balance {login} {operation} {amount} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Performing an operation on the user\'s balance: credit/debit with description';

    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): void
    {
        $login = $this->argument('login');
        $operation = $this->argument('operation');
        $amount = (float)$this->argument('amount');
        $description = $this->argument('description');

        $user = $this->userRepository->getUserByLogin($login);

        if (!$user) {
            $this->error("User with login {$login} not found.");
            return;
        }

        $createOperationDto = CreateOperationDto::from([
            'user' => $user,
            'event_type' => $operation,
            'event_data' => [
                'amount' => $amount,
            ],
            'description' => $description,
        ]);

        ProcessOperationJob::dispatch($createOperationDto);

        $this->info("Operation dispatched to the queue for processing.");
    }
}
