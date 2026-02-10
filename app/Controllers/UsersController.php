<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\UsersModel;
use App\Repositories\UsersRepository;

final class UsersController
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function index(): void
    {
        $users = $this->usersRepository->findAll();
        $title = "Users Overview";

        ob_start();
        require __DIR__ . '/../Views/users/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function show(int $id): void
    {
        $user = $this->usersRepository->findById($id);
        if (!$user) {
            header('Location: ' . BASE_PATH . '/users?error=notfound');
            exit;
        }

        $title = "User #" . $user->getId();

        ob_start();
        require __DIR__ . '/../Views/users/show.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/users?error=unauthorized');
            exit;
        }

        $title = "Create User";

        ob_start();
        require __DIR__ . '/../Views/users/create.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/users?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new UsersModel(
                0, // dummy id
                (int) $_POST['role_id'],
                $_POST['email'],
                password_hash($_POST['password'], PASSWORD_DEFAULT),
                date('Y-m-d H:i:s'),
                null,
                null
            );

            $this->usersRepository->create(
                $user->getRoleId(),
                $user->getEmail(),
                $user->getPasswordHash()
            );

            header('Location: ' . BASE_PATH . '/users?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/users?error=unauthorized');
            exit;
        }

        $user = $this->usersRepository->findById($id);
        if (!$user) {
            header('Location: ' . BASE_PATH . '/users?error=notfound');
            exit;
        }

        $title = "Edit User";

        ob_start();
        require __DIR__ . '/../Views/users/edit.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/users?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new UsersModel(
                $id,
                (int) $_POST['role_id'],
                $_POST['email'],
                !empty($_POST['password'])
                    ? password_hash($_POST['password'], PASSWORD_DEFAULT)
                    : $this->usersRepository->findById($id)->getPasswordHash(),
                '',
                date('Y-m-d H:i:s'),
                null
            );

            $this->usersRepository->update($user);

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
