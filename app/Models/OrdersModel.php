<?php
declare(strict_types=1);

namespace App\Models;

final class OrdersModel
{
    private int $id;
    private ?int $user_id;
    private float $total_price;
    private string $created_at;
    private ?string $updated_at;
    private ?string $deleted_at;

    public function __construct(
        int $id,
        ?int $user_id,
        float $total_price,
        string $created_at,
        ?string $updated_at,
        ?string $deleted_at
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total_price = $total_price;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->deleted_at = $deleted_at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deleted_at;
    }
}
