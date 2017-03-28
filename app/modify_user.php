<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
	header("Location:" . User::baseurl() . "app/login.php");
	exit;
}

session_start();
$type = $_SESSION['type'];

if($type != 3)
{
	header("Location:" . User::baseurl() . "app/logout.php");
}

$args = array(
	'id'  => FILTER_SANITIZE_STRING,
	'name'  => FILTER_SANITIZE_STRING,
	);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setId($post->id);
$user->setEmail($post->email);
$user->saveUser();
header("Location:" . User::baseurl() . "app/admin.php");
?>