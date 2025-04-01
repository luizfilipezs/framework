<?php

namespace Luizfilipezs\Application\Modules\User;

use Luizfilipezs\Application\Modules\User\Dto\{CreateUserDto, UpdateUserDto, UsersSearchDto};
use Luizfilipezs\Container\Attributes\{Lazy, Singleton};

#[Lazy]
#[Singleton]
final class UserService implements UserServiceInterface
{
    public function getAll(UsersSearchDto $create): array
    {
        return [];
    }

    public function get(int $id): ?User
    {
        return null;
    }

    public function create(CreateUserDto $create): User
    {
        return new User();
    }

    public function update(int $id, UpdateUserDto $create): User
    {
        return new User();
    }

    public function delete(int $id): void {}
}
