<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cafe Progate</title>
    <link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico|Lato" rel="stylesheet" type="text/css">
</head>

<body>
    <div class="menu-wrapper container">
        <h1 class="logo">Cafe Progate</h1>
        <h3>メニュー<?php echo Menu::getCount() ?>個</h3>
        <div class="index-menu-list">
            <ul>
                <li><a href="index.php?page=create">メニュー作成</a></li>
                <li><a href="index.php?page=edit">メニュー編集</a></li>
                <li><a href="index.php?page=delete">メニュー削除</a></li>
            </ul>
        </div>
        <div class="menu-container">
            <div class="menu-items">
                <?php foreach ($menus as $menu): ?>
                    <div class="menu-item">
                        <img src="<?php echo $menu->getImage() ?>" class="menu-item-image">
                        <div class="item-info">
                            <h3 class="menu-item-name">
                                <a href="index.php?page=show&id=<?php echo $menu->getId() ?>">
                                    <?php echo $menu->getName() ?>
                                </a>
                            </h3>
                            <p class="amount">在庫: <?php echo $menu->getStock() ?></p>
                            <?php if ($menu instanceof Drink): ?>
                                <p class="menu-item-type"><?php echo $menu->getType() ?></p>
                            <?php else: ?>
                                <?php for ($i = 0; $i < $menu->getSpiciness(); $i++): ?>
                                    <img src="https://s3-ap-northeast-1.amazonaws.com/progate/shared/images/lesson/php/chilli.png"
                                        class="icon-spiciness">
                                <?php endfor ?>
                            <?php endif ?>
                            <p class="price"><?php echo $menu->getTaxIncludedPrice() ?> (税込み)</p>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</body>

</html>
