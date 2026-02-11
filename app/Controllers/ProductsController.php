<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductsRepository;
use App\Repositories\FactionsRepository;

final class ProductsController
{
    private ProductsRepository $productsRepository;

    public function __construct(ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    private function ensureAdmin(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    public function index(): void
    {
        $this->ensureAdmin();

        $products = $this->productsRepository->findAll();
        $title = "Armory Inventory (Admin)";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/products/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        $this->ensureAdmin();

        $product = $this->productsRepository->findById($id);
        if (!$product) {
            header('Location: ' . BASE_PATH . '/products');
            exit;
        }

        $title = "Admin Detail: " . $product->getName();

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/products/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function create(): void
    {
        $this->ensureAdmin();

        $factionsRepository = FactionsRepository::make();
        $factions = $factionsRepository->findAll();

        $title = "Forge New Unit";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/products/create.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function store(): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productsRepository->create(
                $_POST['faction_name'],                 // 👈 naam, geen ID
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                (float) $_POST['price'],
                $_POST['image_url'] ?? '',
                (int) $_POST['stock_quantity']
            );

            header('Location: ' . BASE_PATH . '/products?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $this->ensureAdmin();

        $product = $this->productsRepository->findById($id);
        if (!$product) {
            header('Location: ' . BASE_PATH . '/products');
            exit;
        }

        $factionsRepository = FactionsRepository::make();
        $factions = $factionsRepository->findAll();

        $title = "Modify Unit";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/products/edit.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function update(int $id): void
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->productsRepository->update(
                $id,
                $_POST['faction_name'],                 // 👈 naam, geen ID
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                (float) $_POST['price'],
                $_POST['image_url'] ?? '',
                (int) $_POST['stock_quantity']
            );

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
