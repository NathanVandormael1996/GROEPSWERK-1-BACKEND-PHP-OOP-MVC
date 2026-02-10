<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\OrdersModel;
use PDO;

final class OrdersRepository
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
        $stmt = $this->pdo->query(
            'SELECT * FROM orders WHERE deleted_at IS NULL ORDER BY created_at DESC'
        );

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($rows as $row) {
            $orders[] = $this->mapRowToModel($row);
        }

        return $orders;
    }

    public function findById(int $id): ?OrdersModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM orders WHERE id = :id AND deleted_at IS NULL'
        );
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToModel($row) : null;
    }

    public function create(OrdersModel $order): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO orders (user_id, total_price, created_at)
         VALUES (:user_id, :total_price, :created_at)'
        );

        return $stmt->execute([
            'user_id'     => $order->getUserId(),
            'total_price' => $order->getTotalPrice(),
            'created_at'  => $order->getCreatedAt(),
        ]);
    }

    public function update(OrdersModel $order): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE orders SET
                user_id = :user_id,
                total_price = :total_price,
                updated_at = NOW()
             WHERE id = :id AND deleted_at IS NULL'
        );

        return $stmt->execute([
            'id'          => $order->getId(),
            'user_id'     => $order->getUserId(),
            'total_price' => $order->getTotalPrice(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE orders SET deleted_at = NOW() WHERE id = :id'
        );

        return $stmt->execute(['id' => $id]);
    }

    private function mapRowToModel(array $row): OrdersModel
    {
        return new OrdersModel(
            (int) $row['id'],
            $row['user_id'] !== null ? (int) $row['user_id'] : null,
            (float) $row['total_price'],
            $row['created_at'],
            $row['updated_at'] ?? null,
            $row['deleted_at'] ?? null
        );
    }
}
