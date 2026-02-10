<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\OrdersModel;
use App\Repositories\OrdersRepository;

final class OrdersController
{
    private OrdersRepository $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function index(): void
    {
        $orders = $this->ordersRepository->findAll();
        $title = "Orders Overview";

        ob_start();
        require __DIR__ . '/../Views/orders/index.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function show(int $id): void
    {
        $order = $this->ordersRepository->findById($id);
        if (!$order) {
            header('Location: ' . BASE_PATH . '/orders?error=notfound');
            exit;
        }

        $title = "Order #" . $order->getId();

        ob_start();
        require __DIR__ . '/../Views/orders/show.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function create(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/orders?error=unauthorized');
            exit;
        }

        $title = "Create Order";

        ob_start();
        require __DIR__ . '/../Views/orders/create.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function store(): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/orders?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order = new OrdersModel(
                0, // dummy id, DB regelt AUTO_INCREMENT
                !empty($_POST['user_id']) ? (int) $_POST['user_id'] : null,
                (float) $_POST['total_price'],
                date('Y-m-d H:i:s'),
                null,
                null
            );

            $this->ordersRepository->create($order);

            header('Location: ' . BASE_PATH . '/orders?success=created');
            exit;
        }
    }

    public function edit(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/orders?error=unauthorized');
            exit;
        }

        $order = $this->ordersRepository->findById($id);
        if (!$order) {
            header('Location: ' . BASE_PATH . '/orders?error=notfound');
            exit;
        }

        $title = "Edit Order";

        ob_start();
        require __DIR__ . '/../Views/orders/edit.php';
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layout/public.php';
    }

    public function update(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] < 3) {
            header('Location: ' . BASE_PATH . '/orders?error=unauthorized');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order = new OrdersModel(
                $id,
                isset($_POST['user_id']) ? (int) $_POST['user_id'] : null,
                (float) $_POST['total_price'],
                '',
                date('Y-m-d H:i:s'),
                null
            );

            $this->ordersRepository->update($order);

            header('Location: ' . BASE_PATH . '/orders?success=updated');
            exit;
        }
    }

    public function delete(int $id): void
    {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] !== 4) {
            header('Location: ' . BASE_PATH . '/orders?error=forbidden');
            exit;
        }

        $this->ordersRepository->delete($id);

        header('Location: ' . BASE_PATH . '/orders?success=deleted');
        exit;
    }
}
