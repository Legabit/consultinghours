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
  ?>
  <div class="container">
    <div class="col-lg-12">
      <h2 class="text-center text-primary">Add User</h2>
      <div class="col-lg-6 col-lg-offset-3">
       <form action="save_usr.php" method="post"> 

        <label for="id">id(without A or L)</label>
         <input type="text" name="id" class="form-control"/>
         <br>
         <label for="email">email</label>
         <input type="text" name="email" class="form-control"/>
         <br>
         <label for="name">name</label>
         <input type="text" name="name" class="form-control"/>
         <br>       
         <label for="typeUser">Type of user</label>  <br>
         <input type="radio" name="typeUser" value="1"> Professor<br>
         <input type="radio" name="typeUser" value="2" checked> Student<br> 
         <br>
         

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