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
  $db = new Database;
  $paysheet = filter_input(INPUT_POST, 'id');
  $user = new User($db);
  session_start();
  ?>
  <div class="container">
    <div class="col-lg-12">
      <h2 class="text-center text-primary">Add User</h2>
      <div class="col-lg-6 col-lg-offset-3">
       <form action="modify_usr.php" method="post">  
         <label for="name">name</label>
         <input type="text" name="name" class="form-control"/>
         <input class="btn btn-success btn-block btn-md" type="submit" name="submit" value="Seleccionar"></input>
       </form>
     </div>
     <div class="col-lg-12" style="margin-bottom: 100px">
      <br>
    </div>
  </div>
</div>
</body>
</html>