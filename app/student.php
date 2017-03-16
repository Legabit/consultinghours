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
        $paysheet = filter_input(INPUT_POST, 'student');
        if( ! $paysheet )
        {
            header("Location:" . User::baseurl() . "app/list.php");
        }
        
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Student Interface</h2>
                <h2 class="text-center text-primary">A0<?php echo $paysheet; ?></h2>
                <div class="col-lg-12" style="margin-bottom: 100px">
                    <form action="view.php" method="post">
                        <input type="hidden" value="<?php echo $paysheet; ?>" name="student">
                        <input type="submit" class="btn btn-info btn-block" value="View Appointments">
                    </form>
                </div>
                <div class="col-lg-12" style="margin-bottom: 100px">
                    <form action="chooseProf.php" method="post">
                        <input type="hidden" value="<?php echo $paysheet; ?>" name="student">
                        <input type="submit" class="btn btn-info btn-block" value="Make Apointment">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>