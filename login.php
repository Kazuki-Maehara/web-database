<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>Login page</title>
	</head>
	<body>
	<h1>Login page</h1>

<?php
	// if happened to be returned to this page because of authentication error
	if($_GET['error'] == 1) {
		echo "<h2>Incorrect username or password</h2>";
	}
?>
	<form action="login_check.php" method="POST">
		<table>
			<tr>
				<td>Account</td>
				<td><input type="text" name="account" required></td>
			</td>
			<tr>
				<td>Password</td>
				<td><input type="password" name="password" required></td>
			</td>
		</table>
		<input type="submit" value="Verify">
	</form>
	</body>
</html>
