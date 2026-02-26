<?php
require_once __DIR__ . '/../Models/drink.php';
require_once __DIR__ . '/../Models/food.php';
require_once __DIR__ . '/../Models/review.php';
require_once __DIR__ . '/../Models/user.php';

function getPdo(): PDO {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    $host = 'localhost';
    $db   = 'progate_menu1';
    $user = 'sample1_db';
    $pass = 'sample1_db';

    $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    return $pdo;
}

$pdo = getPdo();

$menus = [];
$menuNameById = [];

$sqlMenus = 'SELECT id, name, price, image, category, type, spiciness FROM menus ORDER BY id';
foreach ($pdo->query($sqlMenus) as $row) {
    if ($row['category'] === 'drink') {
        $menu = new Drink($row['name'], (int)$row['price'], $row['image'], $row['type']);
    } else {
        $menu = new Food($row['name'], (int)$row['price'], $row['image'], (int)$row['spiciness']);
    }
    $menus[] = $menu;
    $menuNameById[(int)$row['id']] = $menu->getName();
}

$users = [];
$userByDbId = [];

$sqlUsers = 'SELECT id, name, gender FROM users ORDER BY id';
foreach ($pdo->query($sqlUsers) as $row) {
    $user = new User($row['name'], $row['gender']);
    $users[] = $user;
    $userByDbId[(int)$row['id']] = $user;
}

$reviews = [];

$sqlReviews = 'SELECT id, user_id, menu_id, body FROM reviews ORDER BY id';
foreach ($pdo->query($sqlReviews) as $row) {
    $menuName = $menuNameById[(int)$row['menu_id']] ?? null;
    $user     = $userByDbId[(int)$row['user_id']] ?? null;

    if ($menuName === null || $user === null) {
        continue;
    }

    $reviews[] = new Review($menuName, $user->getId(), $row['body']);
}
