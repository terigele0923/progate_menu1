<?php $mode = $mode ?? 'create'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($mode === 'edit') ? 'Edit Menu' : 'Create Menu'; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link href='https://fonts.googleapis.com/css?family=Pacifico|Lato' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="menu-wrapper container">
		<h1 class="logo"><?php echo ($mode === 'edit') ? 'Edit Menu' : 'Create Menu'; ?></h1>

		<?php switch ($mode): case 'edit': ?>
			<table class="admin-table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Category</th>
						<th>Price</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($menus as $m): ?>
						<tr>
							<td><?php echo htmlspecialchars($m->getName(), ENT_QUOTES, 'UTF-8') ?></td>
							<td><?php echo ($m instanceof Drink) ? 'drink' : 'food' ?></td>
							<td><?php echo $m->getPrice() ?></td>
							<td><a href="index.php?page=edit&id=<?php echo $m->getId() ?>">Edit</a></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>

			<form action="index.php" method="get">
				<input type="hidden" name="page" value="edit">
				<p>
					<label>Select Menu</label><br>
					<select name="id">
						<option value="">-- choose --</option>
						<?php foreach ($menus as $m): ?>
							<option value="<?php echo $m->getId() ?>" <?php echo ($menu !== null && $menu->getId() === $m->getId()) ? 'selected' : '' ?>>
								<?php echo htmlspecialchars($m->getName(), ENT_QUOTES, 'UTF-8') ?>
							</option>
						<?php endforeach ?>
					</select>
					<input type="submit" value="Load">
				</p>
			</form>

			<?php if ($menu !== null): ?>
				<form action="index.php?page=update" method="post">
					<input type="hidden" name="id" value="<?php echo $menu->getId() ?>">
					<p>
						<label>Name</label><br>
						<input type="text" name="name" value="<?php echo htmlspecialchars($menu->getName(), ENT_QUOTES, 'UTF-8') ?>" required>
					</p>
					<p>
						<label>Price</label><br>
						<input type="number" name="price" min="0" value="<?php echo $menu->getPrice() ?>" required>
					</p>
					<p>
						<label>Image URL</label><br>
						<input type="text" name="image" value="<?php echo htmlspecialchars($menu->getImage(), ENT_QUOTES, 'UTF-8') ?>" required>
					</p>
					<p>
						<label>Category</label><br>
						<select name="category">
							<option value="drink" <?php echo ($menu instanceof Drink) ? 'selected' : '' ?>>drink</option>
							<option value="food" <?php echo ($menu instanceof Food) ? 'selected' : '' ?>>food</option>
						</select>
					</p>
					<p>
						<label>Type (drink only)</label><br>
						<input type="text" name="type" value="<?php echo ($menu instanceof Drink) ? htmlspecialchars($menu->getType(), ENT_QUOTES, 'UTF-8') : '' ?>">
					</p>
					<p>
						<label>Spiciness (food only)</label><br>
						<input type="number" name="spiciness" min="0" value="<?php echo ($menu instanceof Food) ? $menu->getSpiciness() : '' ?>">
					</p>
					<p>
						<input type="submit" value="Update">
					</p>
				</form>
			<?php else: ?>
				<p>Please select a menu to edit.</p>
			<?php endif ?>
		<?php break; default: ?>
			<form action="index.php?page=store" method="post">
				<p>
					<label>Name</label><br>
					<input type="text" name="name" required>
				</p>
				<p>
					<label>Price</label><br>
					<input type="number" name="price" min="0" required>
				</p>
				<p>
					<label>Image URL</label><br>
					<input type="text" name="image" required>
				</p>
				<p>
					<label>Category</label><br>
					<select name="category">
						<option value="drink">drink</option>
						<option value="food">food</option>
					</select>
				</p>
				<p>
					<label>Type (drink only)</label><br>
					<input type="text" name="type">
				</p>
				<p>
					<label>Spiciness (food only)</label><br>
					<input type="number" name="spiciness" min="0">
				</p>
				<p>
					<input type="submit" value="Create">
				</p>
			</form>
		<?php endswitch; ?>

		<p><a href="index.php">Back to list</a></p>
	</div>
</body>
</html>
