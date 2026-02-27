<?php

class OrderController
{
    public function confirm()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../../config/data.php';

        $orderItems = [];
        $totalPayment = 0;
        $errors = [];

        $menuId = (int)($_POST['menu_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 0);
        if ($menuId <= 0 || $quantity <= 0) {
            header('Location: index.php');
            exit;
        }

        $menu = Menu::findById($pdo, $menuId);
        if ($menu === null) {
            $errors[] = 'Menu not found.';
        } else {
            $unitPrice = $menu->getTaxIncludedPrice();
            $itemTotal = $unitPrice * $quantity;
            $totalPayment = $itemTotal;
            $orderItems[] = [
                'id' => $menu->getId(),
                'name' => $menu->getName(),
                'count' => $quantity,
                'total' => $itemTotal,
                'unit_price' => $unitPrice,
            ];
        }

        try {
            if (count($errors) === 0) {
                $pdo->beginTransaction();

                $orderStmt = $pdo->prepare('INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (?, ?, ?, NOW())');
                $orderStmt->execute([null, $totalPayment, 'confirmed']);
                $orderId = (int)$pdo->lastInsertId();

                $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, menu_id, quantity, unit_price, created_at) VALUES (?, ?, ?, ?, NOW())');

                $item = $orderItems[0];
                $ok = Menu::decreaseStockById($pdo, $item['id'], $item['count']);
                if (!$ok) {
                    $currentStock = Menu::getStockById($pdo, $item['id']);
                    $currentStockText = ($currentStock === null) ? 'unknown' : (string)$currentStock;
                    $errors[] = $item['name'] . ' is out of stock (current: ' . $currentStockText . ').';
                } else {
                    $itemStmt->execute([$orderId, $item['id'], $item['count'], $item['unit_price']]);
                }

                if (count($errors) > 0) {
                    $pdo->rollBack();
                } else {
                    $pdo->commit();
                }
            }
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $errors[] = 'An error occurred while processing the order.';
        }

        require __DIR__ . '/../Views/order/confirm.php';
    }
}
