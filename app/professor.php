<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Professor</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
    </head>
    <body>
        <?php
        require_once "../models/User.php";
        $paysheet = filter_input(INPUT_POST, 'professor');
        session_start();
        $_SESSION['gg'] = $paysheet;
        if( ! $paysheet )
        {
            header("Location:" . User::baseurl() . "app/list.php");
        }
        
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Professor Interface</h2>
                <h2 class="text-center text-primary">L0<?php echo $paysheet; ?></h2>
                <div class="col-lg-12" style="margin-bottom: 100px">
                    <form action="showApointments.php" method="post">
                        <input type="hidden" value="<?php echo $paysheet; ?>" name="professor">
                        <input type="submit" class="btn btn-info btn-block" value="Show Apointments">
                    </form>
                </div>
                <div class="col-lg-12" style="margin-bottom: 100px">
                    <form action="makeSchedule.php" method="post">
                        <input type="hidden" value="<?php echo $paysheet; ?>" name="professor">
                        <input type="submit" class="btn btn-info btn-block" value="Make schedule">
                    </form>
                    
                </div>
                <div class="col-lg-12" style="margin-bottom: 100px">
                    <form action="showSchedule.php" method="post">
                        <input type="hidden" value="<?php echo $paysheet; ?>" name="professor">
                        <input type="submit" class="btn btn-info btn-block" value="Show schedule">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>