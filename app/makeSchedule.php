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
        $db = new Database;
        $user = new User($db);
        ?>
        <div class="container">
            <div class="col-lg-12">
                <h2 class="text-center text-primary">Make your schedule</h2>
                <div class="col-lg-6 col-lg-offset-3">
                   <form action="save_schedule.php" method="post"> 
                              
                       <label for="dia">Day:</label> <br>
                        <input type="radio" name="dia" value="Monday" checked> Monday<br>
                       <input type="radio" name="dia" value="Tuesday"> Tuesday<br>
                       <input type="radio" name="dia" value="Wednesday"> Wednesday<br>
                       <input type="radio" name="dia" value="Thursday"> Thursday<br>
                       <input type="radio" name="dia" value="Friday"> Friday<br> 
                       <label for="tipo">Type of hour</label>  <br>
                        <input type="radio" name="tipo" value="class" checked> Class<br>
                       <input type="radio" name="tipo" value="officeHour"> Office Hour<br>
                       <input type="radio" name="tipo" value="freeHour"> Free Hour<br> 
                        <br>
                        <label for="begin_hour">Begin Hour: (Format 15:30)</label>
                        <input type="time" name="begin" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" class="form-control"/>
                        <br>
                        <label for="end_hour">End Hour:</label>
                        <input type="time" name="end" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" class="form-control"/>
                        <br>
                    
                    <input class="btn btn-success btn-block btn-md" type="submit" name="submit" value="Seleccionar"></input>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>