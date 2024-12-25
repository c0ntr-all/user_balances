<?php declare(strict_types=1);

namespace App\DTO\Users;

use Spatie\LaravelData\Data;

class CreateUserDto extends Data
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct()
    {
    }
}
