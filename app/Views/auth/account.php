<?php
$errors = $errors ?? [];
$userId = $userId ?? '';
$userName = $userName ?? '';
$h = static function ($value) {
	return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>新規登録</title>
	<link rel="stylesheet" type="text/css" href="assets/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="assets/login_style.css">
	<link href="https://fonts.googleapis.com/css?family=Pacifico|Lato" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="login container">
		<h1 class="logo">新規登録</h1>

		<div class="create-menu">
			<?php if (count($errors) > 0): ?>
				<p><?php echo $h(implode(' / ', $errors)); ?></p>
			<?php endif; ?>

			<form action="index.php?page=register" method="post" class="menu-form">
				<p>
					<label>ユーザーID</label>
					<input type="text" name="user_id" value="userid" required>
				</p>
				<p>
					<label>ユーザー名</label>
					<input type="text" name="user_name" value="username" required>
				</p>
				<p>
					<label>性別</label>
					<select name="gender" required>
						<option value="male">男性</option>
						<option value="female">女性</option>
						<option value="other">その他</option>
					</select>
				</p>
				<p>
					<label>パスワード</label>
					<input type="password" name="password" required>
				</p>
				<div class="auth-actions">
					<input type="submit" value="登録する">
					<a class="auth-link" href="index.php?page=login">ログイン</a>
				</div>
			</form>

			<p><a href="index.php">メニュー一覧に戻る</a></p>
		</div>
	</div>
</body>

</html>
