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
  $paysheet = filter_input(INPUT_POST, 'id');
  if($type != 3)
  {
    header("Location:" . User::baseurl() . "app/logout.php");
  }
  if(!$paysheet){
    header("Location:" . User::baseurl() . "app/logout.php");
  }
  $db = new Database;
  $user = new User($db);
  $users = $user->getUsuario();
  $student = $user->getNameSt();
  $professor = $user->getNamePr();

  $formerid;
  $formeremail;
  $formername;
  $formertype;

  foreach ($users as $usuar) {
    if($usuar->id==$paysheet){
      $formerid = $usuar->id;
      $formeremail = $usuar->email;
      $formertype = $usuar->type;
    }
  }
  if($formertype == 1){
    foreach ($professor as $prof) {
      if($prof->id==$paysheet)
        $formername = $prof->name;
    }
  }
  if($formertype == 2){
    foreach ($student as $stu) {
      if($stu->id==$paysheet)
        $formername = $stu->name;
    }
  }
  ?>
  <div class="container">
    <div class="col-lg-12">
      <h2 class="text-center text-primary">Edit User</h2>
      <div class="col-lg-6 col-lg-offset-3">
       <form action="modify_user.php" method="post"> 

         <input type="hidden" name="id" value="<?php echo $formerid; ?>" class="form-control" />
         <br>
         <label for="email">email</label>
         <input type="text" name="email" value="<?php echo $formeremail; ?>" class="form-control"/>
         <br>
         <label for="name">name</label>
         <input type="text" name="name" value="<?php echo $formername; ?>" class="form-control"/>
         <br> 
         <input type="hidden" name="typeUser" value="<?php echo $formertype; ?>" class="form-control" />
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