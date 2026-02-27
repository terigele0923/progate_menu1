<?php
$errors = $errors ?? [];
$userId = $userId ?? '';
$h = static function ($value) {
	return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>ログイン</title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="assets/login_style.css">
	<link href="https://fonts.googleapis.com/css?family=Pacifico|Lato" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="login container">
		<h1 class="logo">ログイン</h1>

		<div class="create-menu">
			<?php if (count($errors) > 0): ?>
				<p><?php echo $h(implode(' / ', $errors)); ?></p>
			<?php endif; ?>

			<form action="index.php?page=login" method="post" class="menu-form">
				<p>
					<label>ユーザーID</label>
					<input type="text" name="user_id" value="<?php echo $h($userId); ?>" required>
				</p>
				<p>
					<label>パスワード</label>
					<input type="password" name="password" required>
				</p>
				<div class="auth-actions">
					<input type="submit" value="ログイン">
					<a class="auth-link" href="index.php?page=register">新規登録</a>
				</div>
			</form>

			<p><a href="index.php">メニュー一覧に戻る</a></p>
		</div>
	</div>
</body>

</html>
