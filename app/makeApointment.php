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
        $paysheet = filter_input(INPUT_POST, 'professor');
        if( ! $paysheet )
        {
            header("Location:" . User::baseurl() . "app/list.php");
        }
        $db = new Database;
        $user = new User($db);
        $user->setId($paysheet);
        $users = $user->viewHours();
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Users List</h2>
                <h2 class="text-center text-primary">L0<?php echo $paysheet; ?></h2>

                <form action="saveApointment.php" method="post">
                        <select name="apointment" class="form-control">
                            <?php foreach( $users as $user ) {
                                echo '<option value="'.$user->id.'">'.$user->id.' '.$user->day.' '.$user->start.' '.$user->finish.' '.$user->type. '</option>';
                            }
                            ?>
                        </select>
                        <br>
                        <label for="date">Date (year-month-day):</label>
                        <input type="date" name="date" class="form-control"/>
                        <br>
                        <input class="btn btn-success col-lg-2 col-lg-offset-5" value="Continuar" type="submit">
                    </form>

          
            </div>
        </div>
    </body>
</html>
