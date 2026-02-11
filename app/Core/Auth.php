<?php
declare(strict_types=1);

namespace App\Core;

final class Auth
{

    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        return isset($_SESSION['role_id']) && (int)$_SESSION['role_id'] === 4;
    }

    public static function isManager(): bool
    {
        return isset($_SESSION['role_id']) && (int)$_SESSION['role_id'] >= 3;
    }

    public static function isEmployee(): bool
    {
        return isset($_SESSION['role_id']) && (int)$_SESSION['role_id'] === 2;
    }
}