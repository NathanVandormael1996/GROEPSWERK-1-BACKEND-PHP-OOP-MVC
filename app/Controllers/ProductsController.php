<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProductsModel;
use App\Repositories\ProductsRepository;

final class ProductsController
{
    private ProductsRepository $productsRepository;

    public function __construct()
    {
        $this->productsRepository = new ProductsRepository();
    }

    public function index(): array
    {
        return $this->productsRepository->findAll();
    }

    public function show(int $id): ?ProductsModel
    {
        return $this->productsRepository->findById($id);
    }

    public function store(
        int $factionId,
        string $name,
        string $description,
        float $price,
        string $imageUrl,
        int $stockQuantity
    ): int {
        $product = new ProductsModel(
            null,
            $factionId,
            $name,
            $description,
            $price,
            $imageUrl,
            $stockQuantity,
            date('Y-m-d H:i:s'),
            null,
            null
        );

        return $this->productsRepository->create($product);
    }

    public function update(
        int $id,
        int $factionId,
        string $name,
        string $description,
        float $price,
        string $imageUrl,
        int $stockQuantity
    ): bool {
        $product = new ProductsModel(
            $id,
            $factionId,
            $name,
            $description,
            $price,
            $imageUrl,
            $stockQuantity,
            '',
            date('Y-m-d H:i:s'),
            null
        );

        return $this->productsRepository->update($product);
    }

    public function delete(int $id): bool
    {
        return $this->productsRepository->delete($id);
    }
}
