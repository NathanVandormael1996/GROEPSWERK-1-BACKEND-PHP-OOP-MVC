<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\RolesModel;
use App\Repositories\RolesRepository;

final class RolesController
{
    private RolesRepository $rolesRepository;

    public function __construct()
    {
        $this->rolesRepository = new RolesRepository();
    }

    /** READ ALL */
    public function index(): array
    {
        return $this->rolesRepository->findAll();
    }

    /** CREATE */
    public function store(string $name, string $description): int
    {
        $role = new RolesModel(
            null,
            $name,
            $description
        );

        return $this->rolesRepository->create($role);
    }

    /** UPDATE */
    public function update(int $id, string $name, string $description): bool
    {
        $role = new RolesModel(
            $id,
            $name,
            $description
        );

        return $this->rolesRepository->update($role);
    }
}
