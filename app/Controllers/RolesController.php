<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\RolesRepository;

final class RolesController
{
    private RolesRepository $rolesRepository;

    public function __construct()
    {
        $this->rolesRepository = new RolesRepository();
    }

    public function index(): array
    {
        return $this->rolesRepository->findAll();
    }
}