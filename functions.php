<?php
function sanitize($data)
{
	$conn = db();
	return mysqli_real_escape_string($conn, $data);
}

function array_sanitize(&$item)
{
	$conn = db();
	return mysqli_real_escape_string($conn, $item);
}
//mail exist function
function mail_exists($email)
{
	$conn = db();
	$email = sanitize($email);
	$query = mysqli_query($conn, "Select count(id) as total from login where email = '$email'");
	$email_data = mysqli_fetch_assoc($query);
	if ($email_data['total'] > 0) {
		return true;
	} else {
		return false;
	}
}
//mail exist function

//insert in login table function
function login_insert($login_data)
{
	$conn = db();
	array_walk($login_data, 'array_sanitize');
	$fields = '`' . implode('`,`', array_keys($login_data)) . '`';
	$data = '\' ' . implode('\' ,\'', $login_data) . '\'';
	$query = mysqli_query($conn, "Insert into login ($fields) Values ($data)");
	if ($query) {
		return true;
	} else {
		return false;
	}
}
//insert in login table function

//login function
function login($email, $password)
{
	$conn = db();
	$email = sanitize($email);
	$password = sanitize($password);
	$password = md5($password);
	$query = mysqli_query($conn, "Select * from login where email = '$email' and password = '$password'");
	$userdata = mysqli_fetch_assoc($query);
	$numrows = mysqli_num_rows($query);
	if ($numrows > 0) {
		return $userdata['id'];
	} else {
		return 0;
	}
}
//login function

//logged in function
function logged_in()
{
	return (isset($_SESSION['id'])) ? true : false;
}
//logged in function

//logged in redirect 
function logged_in_redirect()
{
	if (logged_in() === true) {
		header('Location: index.php');
		exit();
	}
}
//logged in redirect

//protect index page
function protect_page()
{
	if (logged_in() === false) {
		header('Location: login.php');
		exit();
	}
}
//protect index page

// admin
function is_admin($user_id)
{
	$conn = db();
	$user_id = (int) $user_id;

	$query = mysqli_query($conn, "SELECT role FROM login WHERE id = $user_id");
	$user_data = mysqli_fetch_assoc($query);

	return ($user_data['role'] === '1');
}

// Fungsi untuk mengambil semua data pengguna
function get_all_users()
{
	$conn = db();
	$query = mysqli_query($conn, "SELECT * FROM login");
	$users = array();

	while ($row = mysqli_fetch_assoc($query)) {
		$users[] = $row;
	}

	return $users;
}

// Fungsi untuk menghapus pengguna berdasarkan ID
function delete_user($user_id)
{
	$conn = db();
	$user_id = (int) $user_id;
	mysqli_query($conn, "DELETE FROM login WHERE id = $user_id");
}

function get_latihan_data()
{
	$conn = db();
	$sql = "SELECT * FROM hasil_ujian";
	$result = $conn->query($sql);

	$latihan_data = array();
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$latihan_data[] = $row;
		}
	}

	$conn->close();
	return $latihan_data;
}
