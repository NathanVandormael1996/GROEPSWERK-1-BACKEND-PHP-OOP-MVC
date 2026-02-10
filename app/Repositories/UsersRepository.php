<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Database;
use App\Models\UsersModel;
use PDO;

final class UsersRepository
{
    private ?PDO $pdo = null;

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function create(UsersModel $user): int
    {
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
