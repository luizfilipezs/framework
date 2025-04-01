<?php

namespace Luizfilipezs\Application\Modules\User;

use Luizfilipezs\Application\Modules\User\Dto\{CreateUserDto, UpdateUserDto, UsersSearchDto};
use Luizfilipezs\Framework\Http\{Body, Controller, Delete, Get, Post, Put, QueryParams};

#[Controller('users')]
final class UserController
{
    public function __construct(private readonly UserServiceInterface $userService) {}

    #[Get]
    public function getAll(#[QueryParams] UsersSearchDto $searchParams): array
    {
        return $this->userService->getAll($searchParams);
    }

    #[Get('{id}')]
    public function get(int $id): ?User
    {
        return $this->userService->get($id);
    }

    #[Post]
    public function create(#[Body] CreateUserDto $user): User
    {
        return $this->userService->create($user);
    }

    #[Put('{id}')]
    public function update(int $id, #[Body] UpdateUserDto $user): User
    {
        return $this->userService->update($id, $user);
    }

    #[Delete('{id}')]
    public function delete(int $id): void
    {
        $this->userService->delete($id);
    }
}
