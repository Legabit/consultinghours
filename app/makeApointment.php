<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <?php
        require_once "../models/User.php";
        $paysheet = filter_input(INPUT_POST, 'student');
        if( ! $paysheet )
        {
            header("Location:" . User::baseurl() . "app/list.php");
        }
        $db = new Database;
        $user = new User($db);
        $user->setId($paysheet);
        $users = $user->viewStudent();
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Users List</h2>
                <h2 class="text-center text-primary">A0<?php echo $paysheet; ?></h2>
                 <form>
                   <input type="radio" name="dia" value="Monday" checked> Monday<br>
                   <input type="radio" name="dia" value="Tuesday"> Tuesday<br>
                   <input type="radio" name="dia" value="Wednesday"> Wednesday<br>
                   <input type="radio" name="dia" value="Thursday"> Thursday<br>
                   <input type="radio" name="dia" value="Friday"> Friday
                 </form> 
            </div>
        </div>
    </body>
</html>