<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Database;
use App\Models\ProductsModel;
use PDO;

final class ProductsRepository
{
    private ?PDO $pdo = null;

    public static function make(): self
    {
        return new self(Database::getConnection());
    }
    public function create(ProductsModel $product): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO products 
            (faction_id, name, description, price, image_url, stock_quantity, created_at)
            VALUES (:faction_id, :name, :description, :price, :image_url, :stock_quantity, NOW())'
        );

        $stmt->execute([
            'faction_id'     => $product->getFactionId(),
            'name'           => $product->getName(),
            'description'    => $product->getDescription(),
            'price'          => $product->getPrice(),
            'image_url'      => $product->getImageUrl(),
            'stock_quantity' => $product->getStockQuantity(),
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT * FROM products WHERE deleted_at IS NULL'
        );

        $products = [];

        foreach ($stmt->fetchAll() as $row) {
            $products[] = $this->mapRowToModel($row);
        }

        return $products;
    }

    public function findById(int $id): ?ProductsModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM products WHERE id = :id AND deleted_at IS NULL'
        );

        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? $this->mapRowToModel($row) : null;
    }

    /** UPDATE */
    public function update(ProductsModel $product): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE products SET
                faction_id = :faction_id,
                name = :name,
                description = :description,
                price = :price,
                image_url = :image_url,
                stock_quantity = :stock_quantity,
                updated_at = NOW()
             WHERE id = :id AND deleted_at IS NULL'
        );

        return $stmt->execute([
            'id'             => $product->getId(),
            'faction_id'     => $product->getFactionId(),
            'name'           => $product->getName(),
            'description'    => $product->getDescription(),
            'price'          => $product->getPrice(),
            'image_url'      => $product->getImageUrl(),
            'stock_quantity' => $product->getStockQuantity(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE products 
             SET deleted_at = NOW() 
             WHERE id = :id AND deleted_at IS NULL'
        );

        return $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): ProductsModel
    {
        return new ProductsModel(
            (int) $row['id'],
            (int) $row['faction_id'],
            $row['name'],
            $row['description'],
            (float) $row['price'],
            $row['image_url'],
            (int) $row['stock_quantity'],
            $row['created_at'],
            $row['updated_at'],
            $row['deleted_at']
        );
    }
}
