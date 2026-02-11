<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\RolesModel;
use App\Repositories\RolesRepository;

final class RolesController
{
    private RolesRepository $rolesRepository;

    public function __construct(RolesRepository $rolesRepository)
    {
        $this->rolesRepository = $rolesRepository;
    }

    private function ensureAdmin(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    public function index(): void
    {
        $this->ensureAdmin();

        $roles = $this->rolesRepository->findAll();
        $title = 'Roles Overview';

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/roles/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        $this->ensureAdmin();

        $role = $this->rolesRepository->findById($id);
        if ($role === null) {
            header('Location: ' . BASE_PATH . '/roles?error=notfound');
            exit;
        }

        $title = 'Role #' . $role->getId();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/roles/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function create(): void
    {
        $this->ensureAdmin();

        $title = 'Create Role';

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/roles/create.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function store(): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_PATH . '/roles');
            exit;
        }

        $role = new RolesModel(
            0, // dummy id, wordt genegeerd bij INSERT
            htmlspecialchars($_POST['name']),
            htmlspecialchars($_POST['description']),
            date('Y-m-d H:i:s'),
            null,
            null
        );

        $this->rolesRepository->create($role);

        header('Location: ' . BASE_PATH . '/roles?success=created');
        exit;
    }

    public function edit(int $id): void
    {
        $this->ensureAdmin();

        $role = $this->rolesRepository->findById($id);
        if ($role === null) {
            header('Location: ' . BASE_PATH . '/roles?error=notfound');
            exit;
        }

        $title = 'Edit Role';

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/roles/edit.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function update(int $id): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_PATH . '/roles');
            exit;
        }

        $role = new RolesModel(
            $id,
            htmlspecialchars($_POST['name']),
            htmlspecialchars($_POST['description']),
            '', // createdAt niet relevant bij update
            date('Y-m-d H:i:s'),
            null
        );

        $this->rolesRepository->update($role);

        header('Location: ' . BASE_PATH . '/roles?success=updated');
        exit;
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/roles?error=forbidden');
            exit;
        }

        $this->rolesRepository->delete($id);

        header('Location: ' . BASE_PATH . '/roles?success=deleted');
        exit;
    }
}
