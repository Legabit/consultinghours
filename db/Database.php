<?php

class Database extends PDO{
 
	//dbname
	private $dbname = "usuario6";
	//host
	private $host 	= "localhost";
	//user database
	private $user 	= "usuario6";
	//password user
	private $pass 	= '72f6d69e59c488f6b693f274e46a90ad11f58221d5';
	//port
	private $port 	= 5432;
    //instance
	private $dbh;
 
	//connect with postgresql and pdo
	public function __construct(){
	    try {
	        $this->dbh = parent::__construct("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->user;password=$this->pass");
	    }
        catch(PDOException $e){
	        echo  $e->getMessage();
	    } 
	}
 
	//función para cerrar una conexión pdo
	public function close(){
    	$this->dbh = null;
	} 
}

?>
