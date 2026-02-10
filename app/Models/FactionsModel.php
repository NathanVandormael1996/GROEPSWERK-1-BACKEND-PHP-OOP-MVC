<?php
declare(strict_types=1);

namespace App\Models;

final class FactionsModel
{
    private ?int $id;
    private string $name;
    private string $description;
    private ?string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;

    public function __construct(
        ?int $id,
        string $name,
        string $description,
        ?string $createdAt = null,
        ?string $updatedAt = null,
        ?string $deletedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getUpdatedAt(): ?string { return $this->updatedAt; }
    public function getDeletedAt(): ?string { return $this->deletedAt; }
}