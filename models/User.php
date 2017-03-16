<?php
require_once("../db/Database.php");
require_once("../interfaces/IUser.php");
class User implements IUser {
    private $con;
    private $id;
    private $student;
    private $professor;
    private $date;
    private $start;
    private $finish;
    private $topic;
    private $dia;
    private $tipo;
    public function __construct(Database $db){
        $this->con = new $db;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setDia($dia)
    {
        $this->dia = $dia;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
    public function setProfessor($professor){
        $this->professor = $professor;
    }
    public function setDate($date){
        $this->date = $date;
    }
    public function setStart($start){
        $this->start = $start;
    }
    public function setFinish($finish){
        $this->finish = $finish;
    }
    public function setTopic($topic){
        $this->topic = $topic;
    }
    public function setStudent($student){
        $this->student= $student;
    }
    //insertamos usuarios en una tabla con postgreSql
    public function save() {
        try{
            $query = $this->con->prepare('INSERT INTO users (username, password) values (?,?)');
            $query->bindParam(1, $this->username, PDO::PARAM_STR);
            $query->bindParam(2, $this->password, PDO::PARAM_STR);
            $query->execute();
            $this->con->close();
        }
        catch(PDOException $e) {
            echo  $e->getMessage();
        }
    }
    public function saveSchedule() {
        try{
            $new =('id from hours order by id desc LIMIT 1');
            $new++;
            $query =$this->con->prepare('INSERT INTO hours (id,dia, professor,time_start,time_finish,tipo,period) values (10,?,01326798,"19:00","20:00","officeHour",1');
            //$query = $this->con->prepare('INSERT INTO hours (id,dia, professor,time_start,time_finish,tipo,period) values (10,?,?,?,?,?,1)');
            //$query->bindParam(1,$new);
            $query->bindParam(1, $this->dia, PDO::PARAM_STR);
            /*$query->bindParam(2, $this->professor, PDO::PARAM_STR);
            $query->bindParam(3, $this->start, PDO::PARAM_STR);
            $query->bindParam(4, $this->finish, PDO::PARAM_STR);
            $query->bindParam(5, $this->tipo, PDO::PARAM_STR);  */  
            //$query->execute();
            //$this->con->close(); 
        }
        catch(PDOException $e) {
            echo  $e->getMessage();
        }
    }
    public function update(){
        try{
            $query = $this->con->prepare('UPDATE users SET username = ?, password = ? WHERE id = ?');
            $query->bindParam(1, $this->username, PDO::PARAM_STR);
            $query->bindParam(2, $this->password, PDO::PARAM_STR);
            $query->bindParam(3, $this->id, PDO::PARAM_INT);
            $query->execute();
            $this->con->close();
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    //obtenemos usuarios de una tabla con postgreSql
    public function viewStudent(){
        try{
            if(!empty($this->id)){
                $query = $this->con->prepare('select hours.professor as "Profesor",(date)date,hours.start,hours.finish,topic from availabledates,hours where officehour = hours.id and student = ?');
                $query->bindParam(1, $this->id, PDO::PARAM_INT);
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->con->prepare('SELECT * FROM student');
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public function viewSchedule(){
        try{
            if(!empty($this->id)){
                $query = $this->con->prepare('select day,start,finish,type from hours where professor = ?');
                $query->bindParam(1, $this->id, PDO::PARAM_INT);
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->con->prepare('SELECT * FROM student');
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public function viewProfessor(){
        try{
            if(!empty($this->id)){
                $query = $this->con->prepare('select availabledates.student,availabledates.date,start,finish,availabledates.topic from hours,availabledates where availabledates.officehour = hours.id and professor = ?');
                $query->bindParam(1, $this->id, PDO::PARAM_INT);
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->con->prepare('SELECT * FROM student ');
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public function get(){
        try{
            if(is_int($this->id)){
                $query = $this->con->prepare('SELECT id FROM student order by id desc');
                //$query->bindParam(1, $this->id, PDO::PARAM_INT);
                $query->execute();
                $this->con->close();
                return $query->fetch(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->con->prepare('SELECT * FROM student');
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public function getProfessor(){
        try{
            if(is_int($this->id)){
                $query = $this->con->prepare('SELECT id FROM professor order by id desc');
                //$query->bindParam(1, $this->id, PDO::PARAM_INT);
                $query->execute();
                $this->con->close();
                return $query->fetch(PDO::FETCH_OBJ);
            }
            else{
                $query = $this->con->prepare('SELECT * FROM professor');
                $query->execute();
                $this->con->close();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public function delete(){
        try{
            $query = $this->con->prepare('DELETE FROM users WHERE id = ?');
            $query->bindParam(1, $this->id, PDO::PARAM_INT);
            $query->execute();
            $this->con->close();
            return true;
        }
        catch(PDOException $e){
            echo  $e->getMessage();
        }
    }
    public static function baseurl() {
         return stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . "/consultinghours/";
    }
    public function checkUser($user) {
        if( !$user ) {
            header("Location:" . User::baseurl() . "app/list.php");
        }
    }
}


?>