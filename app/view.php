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
    session_start();
    $type = $_SESSION['type'];
    $matricula = $_SESSION['matricula'];
    
    if($type != 2)
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }

    if( ! $matricula )
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }
    $db = new Database;
    $user = new User($db);
    $user->setId($matricula);
    $users = $user->viewAppointmentsSt();
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">My Appointments</h2>
            <h2 class="text-center text-primary">A0<?php echo $matricula; ?></h2>
            <?php
            if( ! empty( $users ) )
            {
                ?>
                <table class="table table-striped">
                    <tr>
                        <th>Professor</th>
                        <th>Topic</th>
                        <th>Date</th>
                        <th>Start</th>
                        <th>Finish</th>
                    </tr>
                    <?php foreach( $users as $user )
                    {
                        ?>
                        <tr>
                            <td><?php echo $user->professor ?></td>
                            <td><?php echo $user->topic ?></td>
                            <td><?php echo $user->dateh ?></td>
                            <td><?php echo $user->start ?></td>
                            <td><?php echo $user->finish ?></td>

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
                <div class="alert alert-danger" style="margin-top: 100px">You dont have appointments</div>
                <?php
            }
            ?>
        </div>
        <div class="col-lg-12" style="margin-bottom: 100px">
            <br>
            <br>
            <a class="btn btn-info btn-block" href="student.php">Home</a>
        </div>
    </div>
</body>
</html>