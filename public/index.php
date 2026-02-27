<?php

require_once __DIR__ . '/../app/Controllers/MenuController.php';
require_once __DIR__ . '/../app/Controllers/OrderController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$page = $_GET['page'] ?? 'index';

switch ($page) {
    case 'create':
        (new MenuController())->create();
        break;
    case 'store':
        (new MenuController())->store();
        break;
    case 'edit':
        (new MenuController())->edit();
        break;
    case 'update':
        (new MenuController())->update();
        break;
    case 'delete':
        (new MenuController())->delete();
        break;
    case 'show':
        (new MenuController())->show();
        break;
    case 'confirm':
        (new OrderController())->confirm();
        break;
    case 'login':
        $authController = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->loginPost();
        } else {
            $authController->login();
        }
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'register':
        $authController = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        } else {
            $authController->account();
        }
        break;
    case 'index':
    default:
        (new MenuController())->index();
        break;
}
