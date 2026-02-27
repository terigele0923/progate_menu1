<?php
$pageTitle = 'メニュー削除';
require __DIR__ . '/../shared/header.php';
?>
	<div class="menu-wrapper container">
		<h1 class="logo">メニュー削除</h1>
		<form action="index.php?page=delete" method="post">
			<table class="admin-table">
				<thead>
					<tr>
						<th class="cb">選択</th>
						<th>名前</th>
						<th>カテゴリ</th>
						<th>価格</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($menus as $menu): ?>
						<tr>
							<td class="cb">
								<input type="checkbox" name="ids[]" value="<?php echo $menu->getId() ?>">
							</td>
							<td><?php echo htmlspecialchars($menu->getName(), ENT_QUOTES, 'UTF-8') ?></td>
							<td><?php echo ($menu instanceof Drink) ? 'drink' : 'food' ?></td>
							<td><?php echo $menu->getPrice() ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<input type="submit" value="削除">
		</form>
		<p><a href="index.php">メニュー一覧に戻る</a></p>
	</div>
</body>
</html>
