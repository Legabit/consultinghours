<?php
require_once "../models/User.php";
if (empty($_POST['submit']))
{
      header("Location:" . User::baseurl() . "app/makeSchedule.php");
      exit;
}

session_start();
    $type = $_SESSION['type'];
    $matricula = $_SESSION['matricula'];
    $paysheet = $_SESSION['gg'];
    
    if($type != 2)
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }

    if( ! $matricula )
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }

    if( ! $paysheet )
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }

$args = array(
    'topic'  => FILTER_SANITIZE_STRING,
    'dateh'  => FILTER_SANITIZE_STRING,
    'start'  => FILTER_SANITIZE_STRING,
    'finish'  => FILTER_SANITIZE_STRING,
);
echo "<pre>";
print_r($args); 
$post = (object)filter_input_array(INPUT_POST, $args);
$db = new Database;
$user = new User($db);
$user->setId($matricula);
$user->setProfessor($paysheet);
$user->setTopic($post->topic);
$user->setDate($post->dateh);
$user->setStart($post->start);
$user->setFinish($post->finish);
$user->saveAppointment();
header("Location:" . User::baseurl() . "app/student.php");
?>