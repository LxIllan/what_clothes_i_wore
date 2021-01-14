<?php

    require_once 'AdminUsers.php';

    $adminUsers = new AdminUsers();

    session_start();

    $email = $_POST['email'];
	$password = sha1($_POST['password']);

	$data = $adminUsers->validateSession($email, $password);
	
	if (isset($data)) {
		$_SESSION['user'] = $data;
		header('Location: index.php');
	} else {
		session_destroy();
		header('Location: login.php?error=1&email=' . $email);
	}