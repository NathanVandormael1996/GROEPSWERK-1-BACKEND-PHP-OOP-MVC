<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProductsModel;
use App\Repositories\ProductsRepository;

final class ProductsController
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function index(): void
    {
        $products = $this->productsRepository->findAll();
        $title = "Armory Inventory";
        ob_start();
        require __DIR__ . '/../Views/products/index.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function show(int $id): void
    {
        $product = $this->productsRepository->findById($id);
        if (!$product) {
            header('Location: ' . BASE_PATH . '/products?error=notfound');
            exit;
        }

        $title = $product->getName();
        ob_start();
        require __DIR__ . '/../Views/products/show.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/products?error=unauthorized');
            exit;
        }
        $title = "Forge New Unit";
        ob_start();
        require __DIR__ . '/../Views/products/create.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/products?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new ProductsModel(
                null,
                (int)$_POST['faction_id'],
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                (float)$_POST['price'],
                $_POST['image_url'] ?? '',
                (int)$_POST['stock_quantity'],
                date('Y-m-d H:i:s'),
                null,
                null
            );

            $this->productsRepository->create($product);
            header('Location: ' . BASE_PATH . '/products?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/products?error=unauthorized');
            exit;
        }

        $product = $this->productsRepository->findById($id);
        if (!$product) {
            header('Location: ' . BASE_PATH . '/products?error=notfound');
            exit;
        }

        $title = "Modify Unit";
        ob_start();
        require __DIR__ . '/../Views/products/edit.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/products?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = new ProductsModel(
                $id,
                (int)$_POST['faction_id'],
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                (float)$_POST['price'],
                $_POST['image_url'] ?? '',
                (int)$_POST['stock_quantity'],
                '',
                date('Y-m-d H:i:s'),
                null
            );

            $this->productsRepository->update($product);

            header('Location: ' . BASE_PATH . '/products?success=updated');
            exit;
        }
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/products?error=forbidden');
            exit;
        }
        $this->productsRepository->delete($id);
        header('Location: ' . BASE_PATH . '/products?success=deleted');
        exit;
    }
}