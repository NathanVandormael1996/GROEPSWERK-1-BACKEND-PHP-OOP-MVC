<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductsRepository;

final class CartController
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function index(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $this->productsRepository->findById($productId);
            if ($product) {
                $lineTotal = $product->getPrice() * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'line_total' => $lineTotal
                ];
                $totalPrice += $lineTotal;
            }
        }

        $title = "Your Cart";
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/cart/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function add(int $id): void
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]++;
        } else {
            $_SESSION['cart'][$id] = 1;
        }

        header('Location: ' . BASE_PATH . '/cart');
        exit;
    }

    public function remove(int $id): void
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: ' . BASE_PATH . '/cart');
        exit;
    }
}