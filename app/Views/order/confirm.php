<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Progate</title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link href='https://fonts.googleapis.com/css?family=Pacifico|Lato' rel='stylesheet' type='text/css'>
</head>

<body>
	<div class="order-wrapper">
		<h2>Order Confirmation</h2>
		<?php foreach ($orderItems as $item): ?>
			<p class="order-amount">
				<?php echo $item['name'] . " x " . $item['count'] ?> items
			</p>
			<p class="order-price"><?php echo $item['total'] ?> 円</p>
		<?php endforeach ?>
		<h3 class="total-payment">Total Payment: <?php echo $totalPayment ?> 円</h3>
	</div>
</body>

</html>
