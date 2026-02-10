<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\FactionsModel;
use PDO;

final class FactionsRepository
{
    private ?PDO $pdo = null;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM factions WHERE deleted_at IS NULL ORDER BY name ASC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $factions = [];
        foreach ($rows as $row) {
            $factions[] = $this->mapRowToModel($row);
        }
        return $factions;
    }

    public function findById(int $id): ?FactionsModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM factions WHERE id = :id AND deleted_at IS NULL');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function create(FactionsModel $faction): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO factions (name, description, created_at)
             VALUES (:name, :description, NOW())'
        );

        $stmt->execute([
            'name'        => $faction->getName(),
            'description' => $faction->getDescription(),
        ]);
    }

    public function update(FactionsModel $faction): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE factions SET
                name = :name,
                description = :description,
                updated_at = NOW()
             WHERE id = :id AND deleted_at IS NULL'
        );

        $stmt->execute([
            'id'          => $faction->getId(),
            'name'        => $faction->getName(),
            'description' => $faction->getDescription(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('UPDATE factions SET deleted_at = NOW() WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): FactionsModel
    {
        return new FactionsModel(
            (int)$row['id'],
            $row['name'],
            $row['description'] ?? '',
            $row['created_at'] ?? null,
            $row['updated_at'] ?? null,
            $row['deleted_at'] ?? null
        );
    }
}