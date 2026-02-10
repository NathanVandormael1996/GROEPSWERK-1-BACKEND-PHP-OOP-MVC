<?php
declare(strict_types=1);

namespace App\Models;

final class RolesModel
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $createdAt,
        public ?string $updatedAt = null,
        public ?string $deletedAt = null
    ) {}
}
