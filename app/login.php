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
            $db = new Database;
            $user = new User($db);
            $users = $user->getUsuario();
            foreach ($users as $usuar) {
                if(strcmp($inputemail, $usuar->) == 0){

                }
            }
        }
    ?>
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center text-primary">Login</h2>
            <?php
                if(isset($_POST['submit'])){

                }
            ?>
            <form action="login.php" method="post">            
                <br>
                <label for="topic">Email:</label>
                <input type="text" name="topic" class="form-control"/>
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
