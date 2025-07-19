<?php
// Error reporting aanzetten voor debuggen
error_reporting(E_ALL);
ini_set('display_errors', 1);
//inladen van models, helpers, controllers
require_once __DIR__ . '/autoload.php';

//inladen van environment variabelen
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require_once __DIR__ . '/config.php';

//starten van sessie
session_start();

//connectie maken met DB
$db = new PDO(
    $config['db_connection'] . ':host=' . $config['db_host'] . ';port=' . $config['db_port'] . ';dbname=' . $config['db_database'],
    $config['db_username'],
    $config['db_password']
);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

//router aanmaken, inladen van de routes en runnen
$router = new \Bramus\Router\Router();
require_once __DIR__ . '/routes.php';
$router->run();