<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

class ProductRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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

    public function getAllActive(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE is_deleted = 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}