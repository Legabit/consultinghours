<?php
require_once "../models/User.php";
$id = filter_input(INPUT_POST, 'id');
if( ! $id )
{
	header("Location:" . User::baseurl() . "app/admin.php");
}
session_start();
$type = $_SESSION['type'];

if($type != 3)
{
	header("Location:" . User::baseurl() . "app/logout.php");
}
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setId($id);
$user->deleteUsuario();
header("Location:" . User::baseurl() . "app/admin.php");
?>