<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Controllers\AuthController;
use App\Controllers\ProductsController;
use App\Repositories\UsersRepository;
use App\Repositories\ProductsRepository;

$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_PATH', $scriptName === '/' ? '' : $scriptName);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (BASE_PATH !== '' && strpos($uri, BASE_PATH) === 0) {
    $uri = substr($uri, strlen(BASE_PATH));
}
$uri = '/' . ltrim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

// If not logged in, go to login
$publicRoutes = ['/login'];
if (!isset($_SESSION['user_id']) && !in_array($uri, $publicRoutes)) {
    header('Location: ' . BASE_PATH . '/login');
    exit;
}

$router = new Router();


// Login
$router->get('/', function () {
    header('Location: ' . BASE_PATH . '/login');
    exit;
});

// Authentication Routes
$router->get('/login', function () {
    (new AuthController(UsersRepository::make()))->showLogin();
});
$router->post('/login', function () {
    (new AuthController(UsersRepository::make()))->login();
});
$router->get('/logout', function () {
    session_destroy();
    header('Location: ' . BASE_PATH . '/login');
    exit;
});

// Product
$router->get('/products', function () {
    (new ProductsController(ProductsRepository::make()))->index();
});
$router->get('/products/create', function () {
    (new ProductsController(ProductsRepository::make()))->create();
});
$router->post('/products/store', function () {
    (new ProductsController(ProductsRepository::make()))->store();
});

// Show, Edit, Update, Delete
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

try {
    $router->dispatch($uri, $method);
} catch (Exception $e) {
    http_response_code(404);
    echo "<h1>404 - Lost in the Warp</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}