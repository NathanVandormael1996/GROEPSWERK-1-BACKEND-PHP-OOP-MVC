<?php
declare(strict_types=1);

namespace App\Models;

class Product
{
    private int $id;
    private string $name;
    private string $description;
    private float $price;
    private int $faction_id;
    private int $stock_quantity;

    public function __construct(
        int $id,
        string $name,
        string $description,
        float $price,
        int $faction_id,
        int $stock_quantity
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->faction_id = $faction_id;
        $this->stock_quantity = $stock_quantity;
    }
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getFactionId(): int { return $this->faction_id; }
    public function getStockQuantity(): int { return $this->stock_quantity; }
}