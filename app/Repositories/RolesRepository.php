<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Database;
use App\Models\RolesModel;
use PDO;

final class RolesRepository
{
    private ?PDO $pdo = null;

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id, name, description FROM roles'
        );

        $roles = [];

        foreach ($stmt->fetchAll() as $row) {
            $roles[] = new RolesModel(
                (int) $row['id'],
                $row['name'],
                $row['description']
            );
        }

        return $roles;
    }
}
