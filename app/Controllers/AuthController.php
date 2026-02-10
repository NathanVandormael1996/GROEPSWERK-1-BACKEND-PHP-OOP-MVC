<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UsersRepository;

final class AuthController
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['role_id'] >= 3) {
                header('Location: ' . BASE_PATH . '/products');
            } else {
                header('Location: ' . BASE_PATH . '/');
            }
            exit;
        }

        $title = "Inquisition Login";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/auth/login.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->usersRepository->findByEmail($email);

        if ($user && password_verify($password, $user->getPasswordHash())) {

            $_SESSION['user_id'] = $user->getId();
            $_SESSION['username'] = $user->getUsername();
            $_SESSION['role_id'] = $user->getRoleId();

            if ($user->getRoleId() >= 3) {
                header('Location: ' . BASE_PATH . '/products');
            } else {
                header('Location: ' . BASE_PATH . '/');
            }
            exit;
        }

        header('Location: ' . BASE_PATH . '/login?error=invalid');
        exit;
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: ' . BASE_PATH . '/login');
        exit;
    }
}