<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\FactionsModel;
use App\Repositories\FactionsRepository;

final class FactionsController
{
    private FactionsRepository $factionsRepository;

    public function __construct(FactionsRepository $factionsRepository)
    {
        $this->factionsRepository = $factionsRepository;
    }

    public function index(): void
    {
        $factions = $this->factionsRepository->findAll();
        $title = "Alliance Registry";

        ob_start();
        require __DIR__ . '/../Views/factions/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/factions?error=unauthorized');
            exit;
        }

        $title = "Initialize New Faction";
        ob_start();
        require __DIR__ . '/../Views/factions/create.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/factions?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $faction = new FactionsModel(
                null,
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description'])
            );

            $this->factionsRepository->create($faction);

            header('Location: ' . BASE_PATH . '/factions?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/factions?error=unauthorized');
            exit;
        }

        $faction = $this->factionsRepository->findById($id);
        if (!$faction) {
            header('Location: ' . BASE_PATH . '/factions?error=notfound');
            exit;
        }

        $title = "Update Protocol: " . $faction->getName();
        ob_start();
        require __DIR__ . '/../Views/factions/edit.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/factions?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $faction = new FactionsModel(
                $id,
                htmlspecialchars($_POST['name']),
                htmlspecialchars($_POST['description'])
            );

            $this->factionsRepository->update($faction);

            header('Location: ' . BASE_PATH . '/factions?success=updated');
            exit;
        }
    }

    public function show(int $id): void
    {
        // Iedereen mag kijken, dus geen rol-check hier
        $faction = $this->factionsRepository->findById($id);

        if (!$faction) {
            header('Location: ' . BASE_PATH . '/factions?error=notfound');
            exit;
        }

        $title = "Faction Dossier: " . $faction->getName();
        ob_start();
        require __DIR__ . '/../Views/factions/show.php';
        $content = ob_get_clean();
        require __DIR__ . '/../Views/layout/public.php';
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/factions?error=forbidden');
            exit;
        }

        $this->factionsRepository->delete($id);
        header('Location: ' . BASE_PATH . '/factions?success=deleted');
        exit;
    }
}