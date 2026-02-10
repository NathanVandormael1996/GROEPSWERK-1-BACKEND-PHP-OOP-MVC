<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\OrdersRepository;
use App\Repositories\ProductsRepository; // BELANGRIJK: Deze hebben we nodig voor de cart!
use App\Models\OrdersModel;

final class OrdersController
{
    private OrdersRepository $ordersRepository;
    private ?ProductsRepository $productsRepository;

    public function __construct(OrdersRepository $ordersRepository, ?ProductsRepository $productsRepository = null)
    {
        $this->ordersRepository = $ordersRepository;
        $this->productsRepository = $productsRepository;
    }

    public function index(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }

        $orders = $this->ordersRepository->findAll();
        $title = "Orders Overview";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/orders/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        // Admin check
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }

        $order = $this->ordersRepository->findById($id);
        if (!$order) {
            header('Location: ' . BASE_PATH . '/orders');
            exit;
        }

        $title = "Order #" . $order->getId();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/orders/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: ' . BASE_PATH . '/');
            exit;
        }

        if (!$this->productsRepository) {
            die("ProductsRepository missing in Controller");
        }

        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $this->productsRepository->findById($productId);
            if ($product) {
                $cartItems[] = ['product' => $product, 'quantity' => $quantity];
                $totalPrice += $product->getPrice() * $quantity;
            }
        }

        $this->ordersRepository->createOrderFromCart($_SESSION['user_id'], $totalPrice, $cartItems);
        unset($_SESSION['cart']);
        header('Location: ' . BASE_PATH . '/?success=order_placed');
        exit;
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/orders?error=forbidden');
            exit;
        }
        $this->ordersRepository->delete($id);
        header('Location: ' . BASE_PATH . '/orders?success=deleted');
        exit;
    }
}