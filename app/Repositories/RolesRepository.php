<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\RolesModel;
use PDO;

final class RolesRepository
{
    private ?PDO $pdo = null;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM roles ORDER BY id ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $roles = [];
        foreach ($rows as $row) {
            $roles[] = $this->mapRowToModel($row);
        }

        return $roles;
    }

    public function findById(int $id): ?RolesModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM roles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    private function mapRowToModel(array $row): RolesModel
    {
        return new RolesModel(
            (int)$row['id'],
            $row['name'],
            $row['created_at'] ?? null,
        );
    }
}