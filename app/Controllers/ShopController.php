<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductsRepository;

final class ShopController
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function index(): void
    {
        $products = $this->productsRepository->findAll();
        $title = "Imperial Supply Depot";

        require __DIR__ . '/../Views/layout/header.php';

        require __DIR__ . '/../Views/shop/index.php';

        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        $product = $this->productsRepository->findById($id);

        if (!$product) {
            header('Location: ' . BASE_PATH . '/');
            exit;
        }

        $title = $product->getName();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/shop/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }
}