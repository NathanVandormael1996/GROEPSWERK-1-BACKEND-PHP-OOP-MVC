<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Faction;
use App\Repositories\FactionsRepository;

final class FactionsController
{
    private FactionsRepository $factionsRepository;

    public function __construct(FactionsRepository $factionsRepository)
    {
        $this->factionsRepository = $factionsRepository;
    }

    private function ensureAdmin(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/login');
            exit;
        }
    }

    public function index(): void
    {
        $factions = $this->factionsRepository->findAll();
        $title = "Faction Registry";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/factions/index.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function show(int $id): void
    {
        $faction = $this->factionsRepository->findById($id);
        if (!$faction) {
            header('Location: ' . BASE_PATH . '/factions');
            exit;
        }

        $title = "Faction: " . $faction->getName();
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/factions/show.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function create(): void
    {
        $this->ensureAdmin();
        $title = "Initialize Faction";
        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/factions/create.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function store(): void
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $faction = new Faction(
                null,
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                date('Y-m-d H:i:s'),
                null
            );
            $this->factionsRepository->create($faction);
            header('Location: ' . BASE_PATH . '/factions');
            exit;
        }
    }

    public function edit(int $id): void
    {
        $this->ensureAdmin();
        $faction = $this->factionsRepository->findById($id);
        $title = "Update Protocol";

        require __DIR__ . '/../Views/layout/header.php';
        require __DIR__ . '/../Views/factions/edit.php';
        require __DIR__ . '/../Views/layout/footer.php';
    }

    public function update(int $id): void
    {
        $this->ensureAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $faction = new Faction(
                $id,
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description']),
                '',
                date('Y-m-d H:i:s')
            );
            $this->factionsRepository->update($faction);
            header('Location: ' . BASE_PATH . '/factions');
            exit;
        }
    }

    public function delete(int $id): void
    {
        $this->ensureAdmin();
        $this->factionsRepository->delete($id);
        header('Location: ' . BASE_PATH . '/factions');
        exit;
    }
}