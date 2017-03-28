<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
	header("Location:" . User::baseurl() . "app/makeSchedule.php");
	exit;
}

session_start();
$paysheet = $_SESSION['paysheet'];
$type = $_SESSION['type'];

if($type != 1)
{
	header("Location:" . User::baseurl() . "app/logout.php");
}

if(!$paysheet)
{
	header("Location:" . User::baseurl() . "app/logout.php");
}

$args = array(
	'dia'  => FILTER_SANITIZE_STRING,
	'tipo'  => FILTER_SANITIZE_STRING,
	'start'  => FILTER_SANITIZE_STRING,
	'finish'  => FILTER_SANITIZE_STRING,
	);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setProfessor($paysheet);
$user->setDia($post->dia);
$user->setTipo($post->tipo);
$user->setStart($post->start);
$user->setFinish($post->finish);
$user->saveSchedule();
header("Location:" . User::baseurl() . "app/professor.php");
?>