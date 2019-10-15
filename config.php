<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "vertrigo";
$dbName = "sons";


class Database{

    private $dbHost = "localhost";
    private $dbUser = "root";
    private $dbPassword = "vertrigo";
    private $dbName = "sons";


    public function insertUser($id, $login, $email, $password, $num){

        $connect = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);

        $loginQuery = $connect->query("SELECT user_id FROM users WHERE login='$login'");
        $loginAmount = $loginQuery->num_rows;

        if ($loginAmount > 0) {
           echo "Login już zajęty";
        }
        else{
            $connect->query("INSERT INTO users VALUES (NULL, '$login', '$email', '$password', $num, NULL) ");
        }

       
        
        $connect->close();

    }
}