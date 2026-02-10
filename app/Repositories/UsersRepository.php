<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\UsersModel;
use PDO;

final class UsersRepository
{
    private ?PDO $pdo = null;

    private function make(): void
    {
        if ($this->pdo !== null) {
            return;
        }

        $config = require __DIR__ . '/../config/database.php';

        $this->pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']};charset=utf8mb4",
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function create(UsersModel $user): int
    {
        $this->make();

        $stmt = $this->pdo->prepare(
            'INSERT INTO users (role_id, email, password_hash, created_at)
             VALUES (:role_id, :email, :password_hash, :created_at)'
        );

        $stmt->execute([
            'role_id'       => $user->roleId,
            'email'         => $user->email,
            'password_hash' => $user->passwordHash,
            'created_at'    => $user->createdAt,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        $this->make();

        $stmt = $this->pdo->query(
            'SELECT id, role_id, email, password_hash, created_at FROM users'
        );

        $users = [];

        foreach ($stmt->fetchAll() as $row) {
            $users[] = new UsersModel(
                (int) $row['id'],
                (int) $row['role_id'],
                $row['email'],
                $row['password_hash'],
                $row['created_at']
            );
        }

        return $users;
    }

    public function update(UsersModel $user): bool
    {
        $this->make();

        $stmt = $this->pdo->prepare(
            'UPDATE users
             SET role_id = :role_id,
                 email = :email,
                 password_hash = :password_hash
             WHERE id = :id'
        );

        return $stmt->execute([
            'id'            => $user->id,
            'role_id'       => $user->roleId,
            'email'         => $user->email,
            'password_hash' => $user->passwordHash,
        ]);
    }
}
