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

    public function __construct(
        ?int $id,
        int $roleId,
        string $email,
        string $passwordHash,
        string $createdAt
    ) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
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
}