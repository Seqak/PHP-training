<?php 

$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "vertrigo";
$dbName = "sons";


// $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
// class Database{

//     private $dbHost = "localhost";
//     private $dbUser = "root";
//     private $dbPassword = "vertrigo";
//     private $dbName = "sons";


//     public function insertUser($id, $login, $email, $password, $num){

//         $connect = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);

//         $loginQuery = $connect->query("SELECT user_id FROM users WHERE login='$login'");
//         $loginAmount = $loginQuery->num_rows;

//         if ($loginAmount > 0) {
//            echo "Login już zajęty";
//         }
//         else{
//             $connect->query("INSERT INTO users VALUES (NULL, '$login', '$email', '$password', $num, NULL) ");
//         }
        
//         $connect->close();
//     }

    // public function createHero($name, $class, $hp, $power, $exp){

    //     $connect = new mysqli($this->dbHost, $this->dbUser, $this->dbPassword, $this->dbName);

    //     $insertHeroQuery =  $connect->query("SELECT hero_id FROM hero WHERE name='$name'");

    //     $heroNameAmout = $insertHeroQuery->num_rows;

    //     if ($heroNameAmout > 0) {
    //         echo "Name już zajęte";
    //     }
    //     else{
    //         $connect->query("INSERT INTO hero VALUES (NULL, '$name', '$class', '$hp', '$power', '$exp', 1) ");
    //     }
    // }
?>