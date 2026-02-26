<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Delete Menu</title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link href='https://fonts.googleapis.com/css?family=Pacifico|Lato' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="menu-wrapper container">
		<h1 class="logo">Delete Menu</h1>
		<form action="index.php?page=delete" method="post">
			<table class="admin-table">
				<thead>
					<tr>
						<th>Select</th>
						<th>Name</th>
						<th>Category</th>
						<th>Price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($menus as $menu): ?>
						<tr>
							<td>
								<input type="checkbox" name="ids[]" value="<?php echo $menu->getId() ?>">
							</td>
							<td><?php echo htmlspecialchars($menu->getName(), ENT_QUOTES, 'UTF-8') ?></td>
							<td><?php echo ($menu instanceof Drink) ? 'drink' : 'food' ?></td>
							<td><?php echo $menu->getPrice() ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<input type="submit" value="Delete Selected">
		</form>
		<p><a href="index.php">Back to list</a></p>
	</div>
</body>
</html>
