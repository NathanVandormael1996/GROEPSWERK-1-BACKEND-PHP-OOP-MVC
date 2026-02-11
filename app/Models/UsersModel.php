<?php
declare(strict_types=1);

namespace App\Models;

final class UsersModel
{
    private ?int $id;
    private int $roleId;
    private string $roleName;
    private string $email;
    private string $passwordHash;
    private string $createdAt;
    private ?string $updatedAt;
    private ?string $deletedAt;

    public function __construct(
        ?int $id,
        int $roleId,
        string $roleName,
        string $email,
        string $passwordHash,
        string $createdAt,
        ?string $updatedAt = null,
        ?string $deletedAt = null
    ) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->roleName = $roleName;
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

    public function getUsername(): string
    {
        $parts = explode('@', $this->email);
        return $parts[0] ?? 'Unknown Soldier';
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
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
