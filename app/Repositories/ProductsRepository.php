<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\ProductsModel;
use PDO;

final class ProductsRepository
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
            'SELECT 
                p.*,
                f.name AS faction_name
             FROM products p
             JOIN factions f ON p.faction_id = f.id
             WHERE p.deleted_at IS NULL
             ORDER BY p.created_at DESC'
        );

        return array_map(
            fn ($row) => $this->mapRowToModel($row),
            $stmt->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    public function findById(int $id): ?ProductsModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT 
                p.*,
                f.name AS faction_name
             FROM products p
             JOIN factions f ON p.faction_id = f.id
             WHERE p.id = :id
               AND p.deleted_at IS NULL'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function create(
        string $factionName,
        string $name,
        string $description,
        float $price,
        string $imageUrl,
        int $stockQuantity
    ): ProductsModel {
        $stmt = $this->pdo->prepare(
            'INSERT INTO products (
                faction_id,
                name,
                description,
                price,
                image_url,
                stock_quantity,
                created_at
            ) VALUES (
                (SELECT id FROM factions WHERE name = :faction_name),
                :name,
                :description,
                :price,
                :image_url,
                :stock_quantity,
                NOW()
            )'
        );

        $stmt->execute([
            'faction_name'   => $factionName,
            'name'           => $name,
            'description'    => $description,
            'price'          => $price,
            'image_url'      => $imageUrl,
            'stock_quantity' => $stockQuantity,
        ]);

        return $this->findById((int)$this->pdo->lastInsertId());
    }

    public function update(
        int $id,
        string $factionName,
        string $name,
        string $description,
        float $price,
        string $imageUrl,
        int $stockQuantity
    ): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE products SET
                faction_id = (SELECT id FROM factions WHERE name = :faction_name),
                name = :name,
                description = :description,
                price = :price,
                image_url = :image_url,
                stock_quantity = :stock_quantity,
                updated_at = NOW()
             WHERE id = :id
               AND deleted_at IS NULL'
        );

        return $stmt->execute([
            'id'             => $id,
            'faction_name'   => $factionName,
            'name'           => $name,
            'description'    => $description,
            'price'          => $price,
            'image_url'      => $imageUrl,
            'stock_quantity' => $stockQuantity,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE products
             SET deleted_at = NOW()
             WHERE id = :id'
        );

        return $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): ProductsModel
    {
        return new ProductsModel(
            (int) $row['id'],
            (int) $row['faction_id'],
            $row['faction_name'],
            $row['name'],
            $row['description'] ?? '',
            (float) $row['price'],
            $row['image_url'] ?? '',
            (int) $row['stock_quantity'],
            $row['created_at'],
            $row['updated_at'] ?? null,
            $row['deleted_at'] ?? null
        );
    }
}
