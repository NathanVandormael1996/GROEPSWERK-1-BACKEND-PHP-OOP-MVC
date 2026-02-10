<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\RolesModel;
use PDO;

final class RolesRepository
{
    private ?PDO $pdo = null;

    private function make(): void
    {
        if ($this->pdo !== null) {
            return;
        }

        $config = require __DIR__ . '/../config/database.php';

        $this->pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']};charset=utf8mb4",
            $config['user'],
            $config['pass'],
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function findAll(): array
    {
        $this->make();

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
