<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/autoload.php';

use App\Core\Router;
use App\Controllers\ShopController;
use App\Controllers\AuthController;
use App\Controllers\ProductsController;
use App\Controllers\FactionsController;
use App\Controllers\UsersController;
use App\Controllers\RolesController;
use App\Controllers\OrdersController;
use App\Controllers\CartController;
use App\Repositories\ProductsRepository;
use App\Repositories\FactionsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\UsersRepository;
use App\Repositories\RolesRepository;

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_PATH', $scriptName === '/' ? '' : $scriptName);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (BASE_PATH !== '' && strpos($uri, BASE_PATH) === 0) {
    $uri = substr($uri, strlen(BASE_PATH));
}
$uri = '/' . ltrim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

$publicRoutes = ['/login', '/'];
$isShopRoute = strpos($uri, '/shop/') === 0;

if (!isset($_SESSION['user_id']) && !in_array($uri, $publicRoutes) && !$isShopRoute) {
    header('Location: ' . BASE_PATH . '/login');
    exit;
}

$router = new Router();

// Auth
$router->get('/login', function () {
    (new AuthController(UsersRepository::make()))->showLogin();
});
$router->post('/login', function () {
    (new AuthController(UsersRepository::make()))->login();
});
$router->post('/logout', function () {
    (new AuthController(UsersRepository::make()))->logout();
});

// Shop
$router->get('/', function () {
    (new ShopController(ProductsRepository::make()))->index();
});
$router->get('/shop/product/{id}', function ($id) {
    (new ShopController(ProductsRepository::make()))->show((int)$id);
});

// Cart
$router->get('/cart', function () {
    (new CartController(ProductsRepository::make()))->index();
});
$router->post('/cart/add/{id}', function ($id) {
    (new CartController(ProductsRepository::make()))->add((int)$id);
});
$router->post('/cart/remove/{id}', function ($id) {
    (new CartController(ProductsRepository::make()))->remove((int)$id);
});

$router->post('/orders/create', function () {
    (new OrdersController(OrdersRepository::make(), ProductsRepository::make()))->store();
});

// 4. Orders
$router->get('/orders', function () {
    (new OrdersController(OrdersRepository::make(), ProductsRepository::make()))->index();
});
$router->get('/orders/{id}', function ($id) {
    (new OrdersController(OrdersRepository::make(), ProductsRepository::make()))->show((int)$id);
});
$router->post('/orders/{id}/delete', function ($id) {
    (new OrdersController(OrdersRepository::make(), ProductsRepository::make()))->delete((int)$id);
});

// Products
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

// Factions
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

//Users
$router->get('/users', function () {
    (new UsersController(UsersRepository::make()))->index();
});
$router->get('/users/create', function () {
    (new UsersController(UsersRepository::make()))->create();
});
$router->post('/users/store', function () {
    (new UsersController(UsersRepository::make()))->store();
});
$router->get('/users/{id}', function ($id) {
    (new UsersController(UsersRepository::make()))->show((int)$id);
});
$router->get('/users/{id}/edit', function ($id) {
    (new UsersController(UsersRepository::make()))->edit((int)$id);
});
$router->post('/users/{id}/update', function ($id) {
    (new UsersController(UsersRepository::make()))->update((int)$id);
});
$router->post('/users/{id}/delete', function ($id) {
    (new UsersController(UsersRepository::make()))->delete((int)$id);
});

//Roles
//Users
$router->get('/roles', function () {
    (new RolesController(RolesRepository::make()))->index();
});
$router->get('/roles/create', function () {
    (new RolesController(RolesRepository::make()))->create();
});
$router->post('/roles/store', function () {
    (new RolesController(RolesRepository::make()))->store();
});
$router->get('/roles/{id}', function ($id) {
    (new RolesController(RolesRepository::make()))->show((int)$id);
});
$router->get('/roles/{id}/edit', function ($id) {
    (new RolesController(RolesRepository::make()))->edit((int)$id);
});
$router->post('/roles/{id}/update', function ($id) {
    (new RolesController(RolesRepository::make()))->update((int)$id);
});
$router->post('/roles/{id}/delete', function ($id) {
    (new RolesController(RolesRepository::make()))->delete((int)$id);
});


try {
    $router->dispatch($uri, $method);
} catch (Throwable $e) {
    if (ob_get_level()) ob_clean();
    echo "<div style='background: #330000; color: #ff9999; padding: 20px; font-family: monospace;'>";
    echo "<h1>CRITICAL ERROR (500)</h1>";
    echo "<h2>" . htmlspecialchars($e->getMessage()) . "</h2>";
    echo "<p><strong>File:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Line:</strong> " . $e->getLine() . "</p>";
    echo "<h3>Trace:</h3><pre>" . $e->getTraceAsString() . "</pre>";
    echo "</div>";
    exit;
}