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
        $title = "Inquisition Access Required";
        ob_start();
        require __DIR__ . '/../Views/auth/login.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function login(): void
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->usersRepository->findByEmail($email);

        if ($user && password_verify($password, $user->getPasswordHash())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role_id'] = $user->getRoleId();

            $roleMap = [1 => 'Customer', 2 => 'Staff', 3 => 'Manager', 4 => 'Inquisitor'];
            $_SESSION['role'] = $roleMap[$user->getRoleId()] ?? 'Citizen';

            header('Location: /products');
            exit;
        }

        header('Location: /login?error=invalid');
        exit;
    }
}