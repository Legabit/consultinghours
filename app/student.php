<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student</title>
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

    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Student Interface</h2>
            <h2 class="text-center text-primary">A0<?php echo $matricula; ?></h2>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <form action="view.php" method="post">
                    <input type="hidden" value="<?php echo $matricula; ?>" name="student">
                    <input type="submit" class="btn btn-info btn-block" value="View Appointments">
                </form>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <form action="chooseProf.php" method="post">
                    <input type="hidden" value="<?php echo $matricula; ?>" name="student">
                    <input type="submit" class="btn btn-info btn-block" value="Make Apointment">
                </form>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <br>
                <a class="btn btn-info btn-block" href="changePass.php">Change Password</a>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <br>
                <br>
                <a class="btn btn-info btn-block" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>