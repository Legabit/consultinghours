<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
      header("Location:" . User::baseurl() . "app/makeSchedule.php");
      exit;
}

session_start();
$paysheet = $_SESSION['gg'];
$args = array(
    'id'  => FILTER_SANITIZE_STRING,
);
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setId($post->id);
$user->deleteUsuario();
header("Location:" . User::baseurl() . "admin.php");
?>