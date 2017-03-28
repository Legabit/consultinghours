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
        function makelogin($inputemail, $inputpass){
            $inputpass = sha1($inputpass);
            $db = new Database;
            $user = new User($db);
            $users = $user->getUsuario();
            foreach ($users as $usuar) {
                if(strcmp($inputemail, $usuar->email) == 0){
                    if(strcmp($inputpass, $usuar->password) == 0){
                        switch ($usuar->type) {
                            case 0:
                                $_SESSION['type'] = 0;
                                header('Location: admin.php');
                                break;
                            case 1:
                                $_SESSION['type'] = 1;
                                $_SESSION['paysheet'] = $usuar->id;
                                header('Location: professor.php');
                                break;
                            case 2:
                                $_SESSION['type'] = 2;
                                $_SESSION['matricula'] = $usuar->id;
                                header('Location: student.php');
                                break;
                        }
                    }
                }
            }
        }
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Login</h2>
            <?php
                if(isset($_POST['submit'])){
                    makelogin($_POST['eemail'], $_POST['password']);
                }
            ?>
            <form action="login.php" method="post">            
                <br>
                <label for="topic">Email:</label>
                <input type="text" name="eemail" class="form-control"/>
                <br>
                <label for="dateh">Password:</label>
                <input type="password" name="password" class="form-control"/>
                <br>
                <input class="btn btn-success col-lg-2 col-lg-offset-5" value="Continuar" name="submit" type="submit">
            </form>
        </div>
    </div>
</body>
</html>
