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

        foreach ($menus as $menu) {
            $orderCount = $_POST[$menu->getName()] ?? 0;
            $menu->setOrderCount($orderCount);
            $itemTotal = $menu->getTotalPrice();
            $totalPayment += $itemTotal;

            $orderItems[] = [
                'name' => $menu->getName(),
                'count' => $orderCount,
                'total' => $itemTotal,
            ];
        }

        require __DIR__ . '/../Views/order/confirm.php';
    }
}
