<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\DTO\Users\CreateUserDto;
use App\Services\UserService;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    public function __construct(
        private readonly UserService $userService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $name = $this->ask('Enter the user name');
            $email = $this->ask('Enter the user email');
            $password = $this->secret('Enter the user password');

            $createUserDto = CreateUserDto::from([
                'name' => $name,
                'email' => $email,
                'password' => $password,
            ]);

            $user = $this->userService->createUserWithBalance($createUserDto);

            $this->info("User {$user->name} created successfully!");
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }
}
