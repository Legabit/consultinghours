<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
	header("Location:" . User::baseurl() . "app/logout.php");
	exit;
}

session_start();
$type = $_SESSION['type'];

if($type != 1 && $type != 2)
{
	header("Location:" . User::baseurl() . "app/logout.php");
}

$idusr = $_SESSION['jijitl'];

if(!$idusr){
	header("Location:" . User::baseurl() . "app/logout.php");
}

$args = array(
	'password'  => FILTER_SANITIZE_STRING,
	);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setPassword(sha1($post->password));
$user->setId($idusr);
$user->updatePassword();
header("Location:" . User::baseurl() . "app/logout.php");
?>