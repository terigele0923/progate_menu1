<?php
$pageTitle = '注文確認';
require __DIR__ . '/../shared/header.php';
?>
    <div class="order-wrapper">
        <h2>注文内容確認</h2>
        <?php if (!empty($errors)): ?>
            <p><?php echo htmlspecialchars(implode(' / ', $errors), ENT_QUOTES, 'UTF-8'); ?></p>
        <?php else: ?>
            <?php foreach ($orderItems as $item): ?>
                <p class="order-amount">
                    <?php echo $item['name'] . " x" . $item['count'] ?> 個
                </p>
                <p class="order-price"><?php echo $item['total'] ?> 円</p>
            <?php endforeach ?>
            <h3 class="total-payment">合計金額 <?php echo $totalPayment ?> 円</h3>
        <?php endif; ?>
        <p><a href="index.php">メニュー一覧に戻る</a></p>
    </div>
</body>

</html>
