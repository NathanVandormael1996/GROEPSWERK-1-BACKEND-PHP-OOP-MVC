<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\UsersModel;
use App\Repositories\UsersRepository;

final class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
    }

    public function index(): array
    {
        return $this->usersRepository->findAll();
    }

    public function store(
        int $roleId,
        string $email,
        string $passwordHash,
        string $createdAt
    ): int {
        $user = new UsersModel(
            null,
            $roleId,
            $email,
            $passwordHash,
            $createdAt
        );

        return $this->usersRepository->create($user);
    }

    public function update(
        int $id,
        int $roleId,
        string $email,
        string $passwordHash
    ): bool {
        $user = new UsersModel(
            $id,
            $roleId,
            $email,
            $passwordHash,
            ''
        );

        return $this->usersRepository->update($user);
    }
}
