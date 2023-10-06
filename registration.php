<?php
include "init.php";
if (isset($_POST['submit'])) {
	$username = sanitize($_POST['username']);
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$password = md5($password);
	if (mail_exists($email) == true) {
		echo "<script>alert('Email Sudah dipakai.');</script>";
	} else {
		$login_data = array(
			'id' => '',
			'username' => $username,
			'email' => $email,
			'password' => $password
		);

		$login_success = login_insert($login_data);
		if ($login_success == true) {
			echo "<script>alert('Congratulation! Your account has been created successfully.');</script>";
			echo "<script>window.open('login.php', '_self');</script>";
		} else {
			echo "<script>alert('Registration Failed. Try Again.');</script>";
			echo "<script>window.open('registration.php', '_self');</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="Style/Kedua.css" type="text/css" rel="stylesheet">
	<title>Registration</title>
</head>

<body>
	<div class="horizontal-form">
		<div class="heading">Sign Up</div>
		<div class="form-body">
			<form action="" method="POST">
				<div class="form-group">
					<label for="fname">Name:</label>
					<input type="text" class="form-control" id="fname" name="username" value="" placeholder="Name">
				</div>
				<div class="form-group">
					<label for="EMAIL">Email:</label>
					<input type="email" class="form-control" id="EMAIL" name="email" value="" placeholder="Email">
				</div>
				<div class="form-group">
					<label for="lname">Password:</label>
					<input type="password" class="form-control" id="lname" name="password" value="" placeholder="Password">
				</div>
				<div class="button_box">

					<button type="submit" name="submit" class="btn">Register !</button>
				</div>
			</form>
		</div>
		<div class="footer">Already Register ? <a href="login.php">Sign In</a></div>
	</div>
</body>

</html>