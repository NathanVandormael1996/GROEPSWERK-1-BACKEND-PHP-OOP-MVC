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

    public function index(): void
    {
        $roles = $this->rolesRepository->findAll();
        $title = "Roles Overview";

        ob_start();
        require __DIR__ . '/../Views/roles/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function show(int $id): void
    {
        $role = $this->rolesRepository->findById($id);
        if (!$role) {
            header('Location: ' . BASE_PATH . '/roles?error=notfound');
            exit;
        }

        $title = "Role #" . $role->id;

        ob_start();
        require __DIR__ . '/../Views/roles/show.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 4) {
            header('Location: ' . BASE_PATH . '/roles?error=unauthorized');
            exit;
        }

        $title = "Create Role";

        ob_start();
        require __DIR__ . '/../Views/roles/create.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 4) {
            header('Location: ' . BASE_PATH . '/roles?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = new RolesModel(
                0, // dummy id
                $_POST['name'],
                $_POST['description'],
                date('Y-m-d H:i:s'),
                null,
                null
            );

            $this->rolesRepository->create($role);

            header('Location: ' . BASE_PATH . '/roles?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 4) {
            header('Location: ' . BASE_PATH . '/roles?error=unauthorized');
            exit;
        }

        $role = $this->rolesRepository->findById($id);
        if (!$role) {
            header('Location: ' . BASE_PATH . '/roles?error=notfound');
            exit;
        }

        $title = "Edit Role";

        ob_start();
        require __DIR__ . '/../Views/roles/edit.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 4) {
            header('Location: ' . BASE_PATH . '/roles?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = new RolesModel(
                $id,
                $_POST['name'],
                $_POST['description'],
                '',
                date('Y-m-d H:i:s'),
                null
            );

            $this->rolesRepository->update($role);

            header('Location: ' . BASE_PATH . '/roles?success=updated');
            exit;
        }
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
