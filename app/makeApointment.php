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
    session_start();
    $matricula = $_SESSION['ss'];
    $_SESSION['ss'] = $matricula;
    $_SESSION['gg'] = $paysheet;

    $db = new Database;
    $user = new User($db);
    $user->setId($paysheet);
    $users = $user->viewSchedule();
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Schedule for selected professor</h2>
            <h2 class="text-center text-primary">L0<?php echo $paysheet; ?></h2>
            <?php
            if( ! empty( $users ) )
            {
                ?>
                <table class="table table-striped">
                    <tr>
                        <th>Day</th>
                        <th>Start</th>
                        <th>Finish</th>
                        <th>Type</th>
                    </tr>
                    <?php foreach( $users as $user )
                    {
                        ?>
                        <tr>
                            <td><?php echo $user->day ?></td>
                            <td><?php echo $user->start?></td>
                            <td><?php echo $user->finish ?></td>
                            <td><?php echo $user->type ?></td>

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
                <div class="alert alert-danger" style="margin-top: 100px">The selected professor does not have a schedule.</div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Create appointment</h2>
            <h2 class="text-center text-primary">A0<?php echo $matricula; ?></h2>

            <form action="saveApointment.php" method="post">            
                <br>
                <label for="topic">Topic:</label>
                <input type="text" name="topic" class="form-control"/>
                <br>
                <label for="dateh">Date (yyyy-mm-dd):</label>
                <input type="date" name="dateh" class="form-control"/>
                <br>
                <label for="start">Begin Hour: (Format 15:30:00)</label>
                <input type="text" name="start" class="form-control"/>
                <br>
                <label for="finish">End Hour:</label>
                <input type="text" name="finish" class="form-control"/>
                <br>
                <input class="btn btn-success col-lg-2 col-lg-offset-5" value="Continuar" name="submit" type="submit">
            </form>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <br>
                <br>
                <a class="btn btn-info btn-block" href="list.php">Home</a>
            </div>

        </div>
    </div>
</body>
</html>
