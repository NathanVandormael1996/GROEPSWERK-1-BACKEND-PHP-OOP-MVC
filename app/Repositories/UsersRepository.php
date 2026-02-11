<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\UsersModel;
use PDO;

final class UsersRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function findById(int $id): ?UsersModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                u.*,
                r.name AS role_name
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.id = :id'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT 
                u.*,
                r.name AS role_name
             FROM users u
             JOIN roles r ON u.role_id = r.id'
        );

        return array_map(
            fn ($row) => $this->mapRowToModel($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findByEmail(string $email): ?UsersModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                u.*,
                r.name AS role_name
             FROM users u
             JOIN roles r ON u.role_id = r.id
             WHERE u.email = :email
             LIMIT 1'
        );

        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function create(
        string $roleName,
        string $email,
        string $passwordHash
    ): UsersModel {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (role_id, email, password_hash, created_at)
             VALUES (
                (SELECT id FROM roles WHERE name = :role_name),
                :email,
                :password_hash,
                NOW()
             )'
        );

        $stmt->execute([
            'role_name'     => $roleName,
            'email'         => $email,
            'password_hash' => $passwordHash,
        ]);

        return $this->findById((int) $this->pdo->lastInsertId());
    }

    public function update(
        int $id,
        string $roleName,
        string $email,
        string $passwordHash
    ): void {
        $stmt = $this->pdo->prepare(
            'UPDATE users
             SET
                role_id = (SELECT id FROM roles WHERE name = :role_name),
                email = :email,
                password_hash = :password_hash,
                updated_at = NOW()
             WHERE id = :id'
        );

        $stmt->execute([
            'id'            => $id,
            'role_name'     => $roleName,
            'email'         => $email,
            'password_hash' => $passwordHash,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM users WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): UsersModel
    {
        return new UsersModel(
            (int) $row['id'],
            (int) $row['role_id'],
            $row['role_name'],
            $row['email'],
            $row['password_hash'],
            $row['created_at'],
            $row['updated_at'] ?? null,
            $row['deleted_at'] ?? null
        );
    }
}
