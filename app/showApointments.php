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
        $users = $user->viewProfessor();
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Users List</h2>
                <h2 class="text-center text-primary">L0<?php echo $paysheet; ?></h2>
                <?php
                if( ! empty( $users ) )
                {
                ?>
                <table class="table table-striped">
                    <tr>
                        <th>Student</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Topic</th>
                    </tr>
                    <?php foreach( $users as $user )
                    {
                    ?>
                        <tr>
                            <td><?php echo $user->student ?></td>
                            <td><?php echo $user->date ?></td>
                            <td><?php echo $user->start ?></td>
                            <td><?php echo $user->finish ?></td>
                            <td><?php echo $user->topic ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <?php
                }
                else
                {
                ?>
                <div class="alert alert-danger" style="margin-top: 100px">You dont have apointments</div>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>