<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
    <?php
    require_once "../models/User.php";
    session_start();
    $type = $_SESSION['type'];

    if($type != 3)
    {
        header("Location:" . User::baseurl() . "app/logout.php");
    }
    $db = new Database;
    $user = new User($db);
    $users = $user->getSinAdmin();
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Select user to modify</h2>
            <div class="col-lg-6 col-lg-offset-3">
                <form action="modifyUser.php" method="post">
                    <select name="id" class="form-control">
                        <?php foreach( $users as $user ) {
                            echo '<option value="'.$user->id.'">'.$user->id.'</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <input class="btn btn-success col-lg-2 col-lg-offset-5" value="Continuar" type="submit">
                </form>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <br>
                <br>
                <a class="btn btn-info btn-block" href="admin.php">Home</a>
            </div>
        </div>
    </div>
</body>
</html>