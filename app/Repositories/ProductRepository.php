<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;
use App\Models\Product;

class ProductRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllActive(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE is_deleted = 0");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];
        foreach ($rows as $row) {
            $products[] = new Product(
                (int)$row['id'],
                $row['name'],
                $row['description'],
                (float)$row['price'],
                (int)$row['faction_id'],
                (int)$row['stock_quantity']
            );
        }
        return $products;
    }

    public function getById(int $id): ?Product
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id AND is_deleted = 0");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Product(
            (int)$row['id'],
            $row['name'],
            $row['description'],
            (float)$row['price'],
            (int)$row['faction_id'],
            (int)$row['stock_quantity']
        );
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE products 
                SET name = :name, 
                    description = :description, 
                    price = :price, 
                    faction_id = :faction_id, 
                    stock_quantity = :stock_quantity 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        return $stmt->execute($data);
    }

    public function softDelete(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET is_deleted = 1 WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}