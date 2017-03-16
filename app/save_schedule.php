<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
      header("Location:" . User::baseurl() . "app/makeSchedule.php");
      exit;
}

$args = array(
    'day'  => FILTER_SANITIZE_STRING,
    'type'  => FILTER_SANITIZE_STRING,
    'start'  => FILTER_SANITIZE_STRING,
    'finish'  => FILTER_SANITIZE_STRING,
);

$post = (object)filter_input_array(INPUT_POST, $args);

$db = new Database;
$user = new User($db);
$user->setDay($post->day);
$user->setType($post->type);
$user->setStart($post->start);
$user->setFinish($post->finish)
$user->saveSchedule();
header("Location:" . User::baseurl() . "app/professor.php");
?>