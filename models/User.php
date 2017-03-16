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
    private $day;
    private $type;
    public function __construct(Database $db){
        $this->con = new $db;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function setDay()
    {
        $this->day= $day;
    }
    public function setType()
    {
        $this->type= $type;
    }
    public function setProfessor($professor){
        $this->professor = $professor;
    }
    public function setDate($date){
        $this->date= $date;
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
            $new = $this->con->prepare('select id from hours order by id desc LIMIT 1');
            $new++;
            $query = $this->con->prepare('INSERT INTO hours (day, professor,time_start,time_finish,type,period,id) values (?,?,?,?,?,1,?)');
            $query->bindParam(1, $this->day, PDO::PARAM_STR);
            $query->bindParam(2, $this->professor, PDO::PARAM_STR);
            $query->bindParam(3, $this->start, PDO::PARAM_STR);
            $query->bindParam(4, $this->finish, PDO::PARAM_STR);
            $query->bindParam(5, $this->type, PDO::PARAM_STR);
             $query->bindParam(6,$new);
            $query->execute();
            $this->con->close();
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
    public function get(){
        try{
            if(is_int($this->id)){
                $query = $this->con->prepare('SELECT id FROM student');
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
                $query = $this->con->prepare('SELECT id FROM professor');
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
        if( ! $user ) {
            header("Location:" . User::baseurl() . "app/list.php");
        }
    }
}


?>