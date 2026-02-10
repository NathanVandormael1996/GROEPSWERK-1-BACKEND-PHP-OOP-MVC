<?php
declare(strict_types=1);

namespace App\Models;

final class ProductsModel
{
    private ?int $id;
    private int $factionId;
    private string $name;
    private string $description;
    private float $price;
    private string $imageUrl;
    private int $stockQuantity;
    private string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;

    public function __construct(
        ?int $id,
        int $factionId,
        string $name,
        string $description,
        float $price,
        string $imageUrl,
        int $stockQuantity,
        string $createdAt,
        ?string $updatedAt,
        ?string $deletedAt
    ) {
        $this->id = $id;
        $this->factionId = $factionId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->imageUrl = $imageUrl;
        $this->stockQuantity = $stockQuantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    /* GETTERS */

    public function getId(): ?int { return $this->id; }
    public function getFactionId(): int { return $this->factionId; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getImageUrl(): string { return $this->imageUrl; }
    public function getStockQuantity(): int { return $this->stockQuantity; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function getDeletedAt(): ?string { return $this->deletedAt; }
}