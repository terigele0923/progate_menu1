<?php
$mode = $mode ?? 'create';
$isEdit = ($mode === 'edit');
$menu = $menu ?? null;
$h = static function ($value) {
	return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
$pageTitle = $isEdit ? 'メニュー編集' : 'メニュー作成';
$extraHead = '<script src="assets/category_select_script.js" defer></script>';
require __DIR__ . '/../shared/header.php';
?>
	<div class="menu-wrapper container">
		<h1 class="logo"><?php echo $isEdit ? 'メニュー編集' : 'メニュー作成'; ?></h1>

		<?php switch ($mode):
			case 'edit': ?>
				<table class="admin-table">
					<thead>
						<tr>
							<th>名前</th>
							<th>カテゴリ</th>
							<th>価格</th>
							<th>編集</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($menus as $m): ?>
							<tr>
								<td><?php echo $h($m->getName()); ?></td>
								<td><?php echo ($m instanceof Drink) ? 'drink' : 'food'; ?></td>
								<td><?php echo $h($m->getPrice()); ?></td>
								<td><a href="index.php?page=edit&id=<?php echo $m->getId(); ?>">Edit</a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<p><a href="index.php">メニュー一覧に戻る</a></p>
				<?php if ($menu !== null): ?>
					<div class="create-menu">
						<h2>メニューを編集する</h2>
					<form action="index.php?page=update" method="post" class="menu-form">
						<input type="hidden" name="id" value="<?php echo $menu->getId(); ?>">
						<p>
							<label>名前</label>
							<input type="text" name="name" value="<?php echo $h($menu->getName()); ?>" required>
						</p>
						<p>
							<label>価格</label>
							<input type="number" name="price" min="0" value="<?php echo $h($menu->getPrice()); ?>" required>
						</p>

						<p>
							<label>在庫</label>
							<input type="number" name="stock" min="0" value="<?php echo $h($menu->getStock()); ?>" required>
						</p>

						<p>
							<label>画像URL</label>
							<input type="text" name="image" value="<?php echo $h($menu->getImage()); ?>" required>
						</p>
						<p>
							<label>カテゴリ</label>
							<select name="category">
								<option value="drink" <?php echo ($menu instanceof Drink) ? 'selected' : ''; ?>>drink</option>
								<option value="food" <?php echo ($menu instanceof Food) ? 'selected' : ''; ?>>food</option>
							</select>
						</p>
						
						<p data-field="type">
							<label>タイプ</label>
							<input type="text" name="type"
								value="<?php echo ($menu instanceof Drink) ? $h($menu->getType()) : ''; ?>">
						</p>
						<p data-field="spiciness">
							<label>辛さ</label>
							<input type="number" name="spiciness" min="0"
								value="<?php echo ($menu instanceof Food) ? $h($menu->getSpiciness()) : ''; ?>">
						</p>
						<p>
							<input type="submit" value="更新">
						</p>
					</form>
					</div>
					<p><a href="index.php?page=edit">前のページに戻る</a></p>
				<?php else: ?>
					<p>編集するメニューを選択してください。</p>
				<?php endif; ?>
				<?php break;
			default: ?>
				<div class="create-menu">
					<h2>メニューを作成する</h2>
				<form action="index.php?page=store" method="post" class="menu-form">
					<p>
						<label>名前</label>
						<input type="text" name="name" required>
					</p>
					<p>
						<label>価格</label>
						<input type="number" name="price" min="0" required>
					</p>
					<p>
						<label>在庫</label>
						<input type="number" name="stock" min="0" required>
					</p>
					<p>
						<label>画像URL</label>
						<input type="text" name="image" required>
					</p>
					<p>
						<label>カテゴリ</label>
						<select name="category">
							<option value="drink">drink</option>
							<option value="food">food</option>
						</select>
					</p>
					
					<p data-field="type">
						<label>タイプ</label>
						<input type="text" name="type">
					</p>
					<p data-field="spiciness">
						<label>辛さ</label>
						<input type="number" name="spiciness" min="0">
					</p>
					<p>
						<input type="submit" value="作成">
					</p>
				</form>
				<p><a href="index.php">メニュー一覧に戻る</a></p>
				</div>
		<?php endswitch; ?>
	</div>
</body>

</html>
