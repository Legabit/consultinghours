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
    'email'  => FILTER_SANITIZE_STRING,
    'name'  => FILTER_SANITIZE_STRING,
    'typeUser'  => FILTER_SANITIZE_STRING,
);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$token = substr(sha1(uniqid(rand(), true)),0,16) ;
$user = new User($db);
$user->setId($post->id);
$user->setEmail($post->mail);
$user->setName($post->name);
$user->setTypeUser($post->typeUser);
$user->setPassword($token);
$user->saveUser();
header("Location:" . User::baseurl() . "admin.php");
?>