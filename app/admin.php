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
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Admin Crud</h2>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <a class="btn btn-info btn-block" href="addUser.php">Add User</a>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <a class="btn btn-info btn-block" href="selectUser.php">Modify User</a>
            </div>
            <div class="col-lg-12" style="margin-bottom: 100px">
                <a class="btn btn-info btn-block" href="deleteUser.php">Delete User</a>
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
