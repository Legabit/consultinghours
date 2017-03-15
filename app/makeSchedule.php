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
                    <form >            
                       <label for="day">Day:</label> <br>
                        <input type="radio" name="day" value="Monday" checked> Monday<br>
                       <input type="radio" name="day" value="Tuesday"> Tuesday<br>
                       <input type="radio" name="day" value="Wednesday"> Wednesday<br>
                       <input type="radio" name="day" value="Thursday"> Thursday<br>
                       <input type="radio" name="day" value="Friday"> Friday<br> 
                    </form>
                    <form >            
                       <label for="type">Type of hour</label>  <br>
                        <input type="radio" name="type" value="class" checked> Class<br>
                       <input type="radio" name="type" value="officeHour"> Office Hour<br>
                       <input type="radio" name="type" value="freeHour"> Free Hour<br> 
                    </form>
                     <form >  
                        <br>
                        <label for="begin_hour">Begin Hour: (Format 15:30)</label>
                        <input type="time" name="begin" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" class="form-control"/>
                        <br>
                        <label for="end_hour">End Hour:</label>
                        <input type="time" name="end" pattern="([0-1]{1}[0-9]{1}|20|21|22|23):[0-5]{1}[0-9]{1}" class="form-control"/>
                        <br>
                    </form>
                    <input class="btn btn-success btn-block btn-md" type="submit" name="submit" value="Seleccionar"></input>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>