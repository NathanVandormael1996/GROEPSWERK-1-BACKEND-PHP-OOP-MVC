<?php
declare(strict_types=1);

namespace App\Models;

final class UsersModel
{
    private ?int $id;
    private int $roleId;
    private string $email;
    private string $passwordHash;
    private string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;

    public function __construct(
        ?int $id,
        int $roleId,
        string $email,
        string $passwordHash,
        string $createdAt,
        ?string $updatedAt = null,
        ?string $deletedAt = null
    ) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function getDeletedAt(): ?string
    {
        return $this->deletedAt;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}