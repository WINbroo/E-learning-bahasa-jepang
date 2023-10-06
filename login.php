<?php
include "init.php";
logged_in_redirect();
if (isset($_POST['loginsubmit'])) {
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$login = login($email, $password);
	if ($login == 0) {
		echo "<script>alert('Email atau Password yang adan masukkan salah')</script>";
	} else {
		if (!empty($_POST['rememberme'])) {
			setcookie("member_login", $email, time() + (10 * 365 * 24 * 60 * 60));
			setcookie("member_password", $password, time() + (10 * 365 * 24 * 60 * 60));
		} else {
			if (isset($_COOKIE["member_login"])) {
				setcookie("member_login", "");
			}
			if (isset($_COOKIE["member_password"])) {
				setcookie("member_password", "");
			}
		}
		$_SESSION['id'] = $login;
		header('Location:index.php');
		exit();
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="Style/Kedua.css" type="text/css" rel="stylesheet">
	<title>Log In</title>
</head>

<body>
	<div class="horizontal-form">
		<div class="heading">Login</div>
		<div class="form-body">
			<form action="" method="post">
				<div class="form-group">
					<label for="fname">Email:</label>
					<input type="text" class="form-control" id="fname" name="email" value="<?php if (isset($_COOKIE['member_login'])) {
																								echo $_COOKIE['member_login'];
																							} ?>" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="lname">Password:</label>
					<input type="password" class="form-control" id="lname" name="password" value="<?php if (isset($_COOKIE['member_password'])) {
																										echo $_COOKIE['member_password'];
																									} ?>" placeholder="Password">
				</div>
				<div class="button_box">
					<input class="remember_me" type="checkbox" id="rememberme" name="rememberme" <?php if (isset($_COOKIE["member_login"])) { ?> checked <?php } ?> />
					<label class="remember_me_label" for="rememberme">Remember Me</label>
					<button type="submit" name="loginsubmit" class="btn">Login!</button>
				</div>
			</form>
		</div>
		<div class="footer">New User? <a href="registration.php">Sign Up</a></div>
	</div>
</body>

</html>