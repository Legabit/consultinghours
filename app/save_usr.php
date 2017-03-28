<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
	header("Location:" . User::baseurl() . "app/makeSchedule.php");
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
	'email'  => FILTER_SANITIZE_STRING,
	'name'  => FILTER_SANITIZE_STRING,
	'typeUser'  => FILTER_SANITIZE_STRING,
	);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$token = substr(uniqid(rand(), true),0,16);
//mandar token por mail
$token = sha1($token);
$user = new User($db);
$user->setId($post->id);
$user->setEmail($post->email);
$user->setName($post->name);
$user->setTypeUser($post->typeUser);
$user->setPassword($token);
$user->saveUser();
header("Location:" . User::baseurl() . "app/admin.php");
?>