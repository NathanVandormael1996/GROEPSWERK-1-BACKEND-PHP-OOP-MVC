<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;

class ProductController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(): void
    {
        $products = $this->productRepository->getAllActive();
        require_once __DIR__ . '/../Views/products/index.php';
    }

    public function edit(int $id): void
    {
        $product = $this->productRepository->getById($id);

        if (!$product) {
            header('Location: /products?error=notfound');
            exit;
        }

        require_once __DIR__ . '/../Views/products/edit.php';
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name'           => htmlspecialchars($_POST['name']),
                'description'    => htmlspecialchars($_POST['description']),
                'price'          => (float)$_POST['price'],
                'faction_id'     => (int)$_POST['faction_id'],
                'stock_quantity' => (int)$_POST['stock_quantity']
            ];

            $success = $this->productRepository->update($id, $data);

            if ($success) {
                header('Location: /products?success=updated');
                exit;
            }
        }
    }

    public function delete(int $id): void
    {
        $this->productRepository->softDelete($id);
        header('Location: /products?success=deleted');
        exit;
    }
}