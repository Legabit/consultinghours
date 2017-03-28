<?php
	require_once "../models/User.php";
	session_start();
	session_destroy();
	header("Location:" . User::baseurl() . "app/login.php");
?>