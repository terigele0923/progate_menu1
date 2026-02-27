<?php

class MenuController
{
    public function index()
    {
        require_once __DIR__ . '/../../config/data.php';

        require __DIR__ . '/../Views/menu/index.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../../config/data.php';

        $mode = 'create';
        $menu = null;
        require __DIR__ . '/../Views/menu/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../../config/data.php';

        [$name, $price, $stock, $image, $category, $type, $spiciness] = $this->readMenuInput();
        Menu::create($pdo, $name, $price, $image, $category, $type, $spiciness, $stock);

        header('Location: index.php');
        exit;
    }

    public function edit()
    {
        require_once __DIR__ . '/../../config/data.php';

        $id = $_GET['id'] ?? null;
        $menu = null;
        if ($id !== null && $id !== '') {
            $menu = Menu::findById($pdo, $id);
        }
        if ($menu === null) {
            $menuName = $_GET['name'] ?? '';
            if ($menuName !== '') {
                $menu = Menu::findByName($menus, $menuName);
            }
        }
        $mode = 'edit';
        require __DIR__ . '/../Views/menu/create.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../../config/data.php';

        $id = $_POST['id'] ?? null;
        [$name, $price, $stock, $image, $category, $type, $spiciness] = $this->readMenuInput();
        Menu::updateById($pdo, $id, $name, $price, $image, $category, $type, $spiciness, $stock);

        header('Location: index.php');
        exit;
    }

    public function delete()
    {
        require_once __DIR__ . '/../../config/data.php';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require __DIR__ . '/../Views/menu/delete.php';
            return;
        }

        $ids = $_POST['ids'] ?? [];
        Menu::deleteByIds($pdo, $ids);

        header('Location: index.php');
        exit;
    }

    public function show()
    {
        require_once __DIR__ . '/../../config/data.php';

        $id = $_GET['id'] ?? null;
        $menu = null;
        if ($id !== null && $id !== '') {
            $menu = Menu::findById($pdo, $id);
        }
        if ($menu === null) {
            $menuName = $_GET['name'] ?? '';
            if ($menuName !== '') {
                $menu = Menu::findByName($menus, $menuName);
            }
        }
        if ($menu === null) {
            header('Location: index.php');
            exit;
        }

        $menuReviews = $menu->getReviews($reviews);

        require __DIR__ . '/../Views/menu/show.php';
    }

    private function readMenuInput()
    {
        $name = trim($_POST['name'] ?? '');
        $price = (int)($_POST['price'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $image = trim($_POST['image'] ?? '');
        $category = $_POST['category'] ?? '';
        $type = trim($_POST['type'] ?? '');
        $spicinessRaw = trim((string)($_POST['spiciness'] ?? ''));

        $category = ($category === 'drink' || $category === 'food') ? $category : null;
        $type = ($type === '') ? null : $type;
        $spiciness = ($spicinessRaw === '') ? null : (int)$spicinessRaw;

        if ($category === 'drink') {
            return [$name, $price, $stock, $image, 'drink', $type, null];
        }
        if ($category === 'food') {
            return [$name, $price, $stock, $image, 'food', null, $spiciness];
        }
        return [$name, $price, $stock, $image, null, null, null];
    }
}
