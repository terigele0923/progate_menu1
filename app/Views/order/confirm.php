<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>注文確認</title>
    <link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico|Lato" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="order-wrapper">
        <h2>注文確認</h2>
        <?php if (!empty($errors)): ?>
            <p><?php echo htmlspecialchars(implode(' / ', $errors), ENT_QUOTES, 'UTF-8'); ?></p>
        <?php else: ?>
            <?php foreach ($orderItems as $item): ?>
                <p class="order-amount">
                    <?php echo $item['name'] . " × " . $item['count'] ?> 個
                </p>
                <p class="order-price"><?php echo $item['total'] ?> 円</p>
            <?php endforeach ?>
            <h3 class="total-payment">合計: <?php echo $totalPayment ?> 円</h3>
        <?php endif; ?>
        <p><a href="index.php">メニュー一覧へ戻る</a></p>
    </div>
</body>

</html>
