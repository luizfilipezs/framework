<?php

namespace Luizfilipezs\Application\Modules\User;

use Luizfilipezs\Application\Modules\User\Dto\{CreateUserDto, UpdateUserDto, UsersSearchDto};

interface UserServiceInterface
{
    public function getAll(UsersSearchDto $create): array;
    public function get(int $id): ?User;
    public function create(CreateUserDto $create): User;
    public function update(int $id, UpdateUserDto $create): User;
    public function delete(int $id): void;
}
