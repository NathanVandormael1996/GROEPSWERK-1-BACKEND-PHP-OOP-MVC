<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\RolesModel;
use PDO;

final class RolesRepository
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

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM roles ORDER BY id ASC'
        );

        return array_map(
            fn (array $row) => $this->mapRowToModel($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?RolesModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM roles WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function create(RolesModel $role): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO roles (name, description, created_at)
             VALUES (:name, :description, NOW())'
        );

        $stmt->execute([
            'name' => $role->getName(),
            'description' => $role->getDescription(),
        ]);
    }

    public function update(RolesModel $role): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE roles
             SET name = :name,
                 description = :description,
                 updated_at = NOW()
             WHERE id = :id'
        );

        $stmt->execute([
            'id' => $role->getId(),
            'name' => $role->getName(),
            'description' => $role->getDescription(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM roles WHERE id = :id'
        );

        $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): RolesModel
    {
        return new RolesModel(
            (int) $row['id'],
            $row['name'],
            $row['description'],
            $row['created_at'],
            $row['updated_at'] ?? null,
            $row['deleted_at'] ?? null
        );
    }
}
