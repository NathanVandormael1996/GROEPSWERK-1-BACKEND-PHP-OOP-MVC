<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use App\Models\OrdersModel;
use PDO;
use Exception;

final class OrdersRepository
{
    private ?PDO $pdo = null;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public static function make(): self
    {
        $db = new Database();
        return new self($db->getConnection());
    }

    public function createOrderFromCart(int $userId, float $totalPrice, array $cartItems): void
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total_price, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$userId, $totalPrice]);
            $orderId = (int)$this->pdo->lastInsertId();

            $stmtLine = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");

            $stmtStock = $this->pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ?");

            foreach ($cartItems as $item) {
                $prodId = $item['product']->getId();
                $qty = $item['quantity'];
                $price = $item['product']->getPrice();

                $stmtLine->execute([$orderId, $prodId, $qty, $price]);

                $stmtStock->execute([$qty, $prodId]);
            }

            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM orders WHERE deleted_at IS NULL ORDER BY created_at DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];
        foreach ($rows as $row) { $orders[] = $this->mapRowToModel($row); }
        return $orders;
    }

    public function findById(int $id): ?OrdersModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE id = :id AND deleted_at IS NULL');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->mapRowToModel($row) : null;
    }

    public function update(OrdersModel $order): bool
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET user_id = :user_id, total_price = :total_price, updated_at = NOW() WHERE id = :id');
        return $stmt->execute([
            'id' => $order->getId(),
            'user_id' => $order->getUserId(),
            'total_price' => $order->getTotalPrice(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET deleted_at = NOW() WHERE id = :id');
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

    public function create(OrdersModel $order): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (user_id, total_price, created_at) VALUES (:user_id, :total_price, :created_at)');
        return $stmt->execute([
            'user_id' => $order->getUserId(),
            'total_price' => $order->getTotalPrice(),
            'created_at' => $order->getCreatedAt(),
        ]);
    }
}