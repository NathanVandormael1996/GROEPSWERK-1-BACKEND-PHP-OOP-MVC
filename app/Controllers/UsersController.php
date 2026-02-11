<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;

final class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
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

        $users = $this->usersRepository->findAll();
        $title = "Users Overview";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/users/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        $this->ensureAdmin();

        $user = $this->usersRepository->findById($id);
        if (!$user) {
            header('Location: ' . BASE_PATH . '/users?error=notfound');
            exit;
        }

        $title = "User #" . $user->getId();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/users/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function create(): void
    {
        $this->ensureAdmin();

        $rolesRepository = RolesRepository::make();
        $roles = $rolesRepository->findAll();

        $title = "Create User";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/users/create.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }


    public function store(): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->usersRepository->create(
                $_POST['role_name'],
                htmlspecialchars($_POST['email']),
                password_hash($_POST['password'], PASSWORD_DEFAULT)
            );

            header('Location: ' . BASE_PATH . '/users?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $this->ensureAdmin();

        $user = $this->usersRepository->findById($id);
        if (!$user) {
            header('Location: ' . BASE_PATH . '/users?error=notfound');
            exit;
        }

        $rolesRepository = RolesRepository::make();
        $roles = $rolesRepository->findAll();

        $title = "Edit User";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/users/edit.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }


    public function update(int $id): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $existingUser = $this->usersRepository->findById($id);

            $passwordHash = !empty($_POST['password'])
                ? password_hash($_POST['password'], PASSWORD_DEFAULT)
                : $existingUser->getPasswordHash();

            $this->usersRepository->update(
                $id,
                $_POST['role_name'],                     // <-- rolename
                htmlspecialchars($_POST['email']),
                $passwordHash
            );

            header('Location: ' . BASE_PATH . '/users?success=updated');
            exit;
        }
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/users?error=forbidden');
            exit;
        }

        $this->usersRepository->delete($id);

        header('Location: ' . BASE_PATH . '/users?success=deleted');
        exit;
    }
}
