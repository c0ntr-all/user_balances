<?php declare(strict_types=1);

namespace App\Services;

use App\DTO\Users\CreateUserDto;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function createUserWithBalance(CreateUserDto $createUserDto): User
    {
        if (User::where('email', $createUserDto->email)->exists()) {
            throw new \Exception('A user with this email already exists!');
        }

        return DB::transaction(function () use ($createUserDto) {
            $user = $this->createUser($createUserDto);
            $user->balance()->create();

            return $user;
        });
    }

    public function createUser(CreateUserDto $createUserDto): User
    {
        return $this->userRepository->create([
            'name' => $createUserDto->name,
            'email' => $createUserDto->email,
            'password' => Hash::make($createUserDto->password),
        ]);
    }
}
