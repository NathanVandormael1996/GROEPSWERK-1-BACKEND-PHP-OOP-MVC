<?php
// database.php
declare(strict_types=1);

$env = parse_ini_file(__DIR__ . '/.env');

if ($env === false) {
    die("Kan het .env bestand niet vinden of lezen!");
}

return [
    'host'    => $env['DB_HOST'],
    'dbname'  => $env['DB_NAME'],
    'user'    => $env['DB_USER'],
    'pass'    => $env['DB_PASS'],
    'port'    => $env['DB_PORT'],
];