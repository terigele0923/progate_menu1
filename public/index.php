<?php

require_once __DIR__ . '/../app/Controllers/MenuController.php';
require_once __DIR__ . '/../app/Controllers/OrderController.php';

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
    case 'index':
    default:
        (new MenuController())->index();
        break;
}
