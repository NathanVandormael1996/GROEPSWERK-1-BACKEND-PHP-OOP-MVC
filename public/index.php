<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/autoload.php';

use App\Controllers\OrdersController;
use App\Controllers\FactionsController;
use App\Core\Router;
use App\Controllers\ShopController;
use App\Controllers\AuthController;
use App\Controllers\ProductsController;
use App\Repositories\OrdersRepository;
use App\Repositories\FactionsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\ProductsRepository;
use App\Repositories\FactionsRepository;

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_PATH', $scriptName === '/' ? '' : $scriptName);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (BASE_PATH !== '' && strpos($uri, BASE_PATH) === 0) {
    $uri = substr($uri, strlen(BASE_PATH));
}
$uri = '/' . ltrim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

// Publieke routes (Login & Shop)
$publicRoutes = ['/login', '/'];
$isShopRoute = strpos($uri, '/shop/') === 0; // Alles wat met /shop/ begint is ook ok

if (!isset($_SESSION['user_id']) && !in_array($uri, $publicRoutes) && !$isShopRoute) {
    header('Location: ' . BASE_PATH . '/login');
    exit;
}

$router = new Router();

// 1. AUTH
$router->get('/login', function () {
    (new AuthController(UsersRepository::make()))->showLogin();
});
$router->post('/login', function () {
    (new AuthController(UsersRepository::make()))->login();
});
$router->post('/logout', function () {
    (new AuthController(UsersRepository::make()))->logout();
});

// 2. SHOP (KLANT)
$router->get('/', function () {
    (new ShopController(ProductsRepository::make()))->index();
});
$router->get('/shop/product/{id}', function ($id) {
    (new ShopController(ProductsRepository::make()))->show((int)$id);
});

// 3. PRODUCTS (ADMIN)
$router->get('/products', function () {
    (new ProductsController(ProductsRepository::make()))->index();
});
$router->get('/products/create', function () {
    (new ProductsController(ProductsRepository::make()))->create();
});
$router->post('/products/store', function () {
    (new ProductsController(ProductsRepository::make()))->store();
});
$router->get('/products/{id}', function ($id) {
    (new ProductsController(ProductsRepository::make()))->show((int)$id);
});
$router->get('/products/{id}/edit', function ($id) {
    (new ProductsController(ProductsRepository::make()))->edit((int)$id);
});
$router->post('/products/{id}/update', function ($id) {
    (new ProductsController(ProductsRepository::make()))->update((int)$id);
});
$router->post('/products/{id}/delete', function ($id) {
    (new ProductsController(ProductsRepository::make()))->delete((int)$id);
});

//Orders
$router->get('/orders', function () {
    (new OrdersController(OrdersRepository::make()))->index();
});
$router->get('/orders/create', function () {
    (new OrdersController(OrdersRepository::make()))->create();
});
$router->post('/orders/store', function () {
    (new OrdersController(OrdersRepository::make()))->store();
});

// Show, Edit, Update, Delete
$router->get('/orders/{id}', function ($id) {
    (new OrdersController(OrdersRepository::make()))->show((int)$id);
});

$router->get('/orders/{id}/edit', function ($id) {
    (new OrdersController(OrdersRepository::make()))->edit((int)$id);
});

$router->post('/orders/{id}/update', function ($id) {
    (new OrdersController(OrdersRepository::make()))->update((int)$id);
});

$router->post('/orders/{id}/delete', function ($id) {
    (new OrdersController(OrdersRepository::make()))->delete((int)$id);
});

// --- FACTION ROUTES ---
$router->get('/factions', function () {
    (new FactionsController(FactionsRepository::make()))->index();
});
$router->get('/factions/create', function () {
    (new FactionsController(FactionsRepository::make()))->create();
});
$router->post('/factions/store', function () {
    (new FactionsController(FactionsRepository::make()))->store();
});
$router->get('/factions/{id}', function ($id) {
    (new FactionsController(FactionsRepository::make()))->show((int)$id);
});
$router->get('/factions/{id}/edit', function ($id) {
    (new FactionsController(FactionsRepository::make()))->edit((int)$id);
});
$router->post('/factions/{id}/update', function ($id) {
    (new FactionsController(FactionsRepository::make()))->update((int)$id);
});
$router->post('/factions/{id}/delete', function ($id) {
    (new FactionsController(FactionsRepository::make()))->delete((int)$id);
});


try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    http_response_code(404);
    echo "<h1>404 - Pagina niet gevonden</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='" . BASE_PATH . "/'>Terug naar Home</a>";
}