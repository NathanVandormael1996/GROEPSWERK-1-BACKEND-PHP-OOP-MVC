<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\UsersModel;
use PDO;

final class UsersRepository
{
    private ?PDO $pdo = null;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function findByEmail(string $email): ?UsersModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE email = :email'
        );

        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->mapRowToModel($row);
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $users = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $users[] = $this->mapRowToModel($row);
        }

        return $users;
    }

    private function mapRowToModel(array $row): UsersModel
    {
        return new UsersModel(
            (int)$row['id'],
            (int)$row['role_id'],
            $row['email'],
            $row['password_hash'],
            $row['created_at']
        );
    }
}