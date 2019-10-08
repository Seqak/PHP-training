<?php
session_start();

require_once('config.php');

if (isset($_POST['login'])) {

    $login = $_POST['login'];

    //Connection to DB
    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($connect->connect_errno != 0) {
        echo "We have a problem with Database connect. Contact with support.";
    }


    if (!$connect) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit();
    }

    $checkFields = true;

    if ( strlen($_POST['login']) < 3 || strlen($_POST['login']) > 20 ) {

        $checkFields = false;

        
        $_SESSION['e_login'] =  '<span style="color: red">Niewłaściwa ilość liter w loginie</span> <br>';

    }

    if (isset($_POST['email'])) {
                    
                
        $email = htmlspecialchars($_POST['email']);
        $regEx = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/';

        if (preg_match($regEx, $email) ) {
            
        }
        else{
            $_SESSION['e_email'] = '<span style="color: red">Niepoprawny adres email.</span><br>';

            $checkFields = false;
        }
    }

    if (isset($_POST['password'])) {
                    
        $password = htmlspecialchars($_POST['password']); 
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        if (strlen($password) < 8 || strlen($password) > 16) {
            
            $_SESSION['e_password'] = '<span style="color: red">Niewłaściwy format hasła.</span><br><br>';

            $checkFields = false;
        }
    }
    
    //Insert user to DB
    if ($checkFields == true) {
        
        $connect->query("INSERT INTO users VALUES (NULL, '$login', '$email', '$password_hashed') ");
        header('Location: index.php');
        

    }
    
    
}



?>

<!DOCTYPE html>
<html>
    <head>
        <title>Siema</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label>Login</label><br>
            <input type="text" name="login" placeholder="Login"> <br>
            
            <?php
            if (isset($_SESSION['e_login'])) {
                echo $_SESSION['e_login'];unset($_SESSION['e_login']);
            }
            ?>


            <br><label>E-mail</label><br>
            <input type="text" name="email" placeholder="E-mail"> <br>
            

            <?php
                if (isset($_SESSION['e_email'])) {
                    echo $_SESSION['e_email'];unset($_SESSION['e_email']);
                }
            ?>

            <br><label>Password</label><br>
            <input type="password" name="password" placeholder="Password"><br>
            <small><span style="color: #666666;">Hasło musi mieć przynajmeniej 8 znaków. Max 16.</span></small><br>

            <?php
                if (isset($_SESSION['e_password'])) {
                    echo $_SESSION['e_password'];unset($_SESSION['e_password']);   
                }             
            ?>

            <button type="button"><a href="/sons/index.php">Anuluj</a></button>
            <button type="submit">Register</button>               

        </form>
    </body>

</html>