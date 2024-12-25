<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function getUserByLogin(string $login): ?User
    {
        return User::where('name', $login)->first();
    }
}
