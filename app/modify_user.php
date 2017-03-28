<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
	header("Location:" . User::baseurl() . "app/admin.php");
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
	'typeUser' => FILTER_SANITIZE_STRING,
	);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setId($post->id);
$user->setEmail($post->email);
$user->setName($post->name);
$user->setTypeUser($post->typeUser);
echo $post->id;
echo $post->email;
echo $post->name;
echo $post->typeUser;
$user->updateUser();
header("Location:" . User::baseurl() . "app/admin.php");
?>