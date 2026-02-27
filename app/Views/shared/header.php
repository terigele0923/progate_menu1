<?php
$contentTypeHeaderSent = headers_sent();
if (!$contentTypeHeaderSent) {
	header('Content-Type: text/html; charset=UTF-8');
}
$pageTitle = $pageTitle ?? 'Cafe Progate';
if (!isset($h) || !is_callable($h)) {
	$h = static function ($value) {
		return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
	};
}
$extraHead = $extraHead ?? '';
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $h($pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link href="https://fonts.googleapis.com/css?family=Pacifico|Lato" rel="stylesheet" type="text/css">
	<?php if ($extraHead !== ''): ?>
		<?php echo $extraHead; ?>
	<?php endif; ?>
</head>

<body>
	<header class="site-header">
		<div class="nav-inner container">
			<a class="site-brand" href="index.php">Cafe Progate</a>
			<input type="checkbox" id="nav-toggle" class="nav-toggle">
			<label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation">
				<span></span>
				<span></span>
				<span></span>
			</label>
			<nav class="site-nav">
				<ul class="nav-list">
					<li><a href="index.php?page=index">メニュー</a></li>
					<li><a href="index.php?page=reviews">レビュー</a></li>
					<li><a href="index.php?page=login">ログイン</a></li>
					<li><a href="index.php?page=logout">ログアウト</a></li>
					<li><a href="index.php?page=edit">メニュー編集</a></li>
					<li><a href="index.php?page=delete">メニュー削除</a></li>
					<li><a href="index.php?page=create">メニュー作成</a></li>
					<li><a href="index.php?page=account">アカウント</a></li>
				</ul>
			</nav>
		</div>
	</header>
