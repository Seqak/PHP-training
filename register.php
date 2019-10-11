<?php
session_start();

require_once('config.php');

if (isset($_POST['login'])) {


    $login = htmlspecialchars( $_POST['login']);

    //Connection to DB
    $connect = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($connect->connect_errno != 0) {
        echo "We have a problem with Database connect. Contact with support.";
    }


    $checkFields = true;

    if ( strlen($_POST['login']) < 3 || strlen($_POST['login']) > 20 ) {

        $checkFields = false;

        
        $_SESSION['e_login'] =  '<span style="color: red">Niewłaściwa ilość liter w loginie</span> <br>';

    }

    if (isset($_POST['login'])){
         $loginCheckResult = $connect->query("SELECT userid FROM users WHERE login='$login'");
            if (!$loginCheckResult) {
                throw new Exception($connect->error);
            }

         $loginAmount = $loginCheckResult->num_rows;
        
        if ($loginAmount > 0) {
            $_SESSION['e_login'] = '<span style="color: red">Podany login już jest zajęty.</span><br>';
            $checkFields = false;
        }
    }

    if (isset($_POST['email'])) {
                    
                
        $email = htmlspecialchars($_POST['email']);
        $regEx = '/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/';

        $emailCheckResult = $connect->query("SELECT userid FROM users WHERE email='$email'");
            if (!$emailCheckResult) {
                throw new Exception($connect->error);
            }

        $emailAmount = $emailCheckResult->num_rows;
        
        if ($emailAmount > 0) {
            $_SESSION['e_email'] = '<span style="color: red">Podany adres email już jest zajęty.</span><br>';
            $checkFields = false;
            $connect->close();
        }



            if (preg_match($regEx, $email) ) {
                
            }
            else{
                $_SESSION['e_email'] = '<span style="color: red">Niepoprawny adres email.</span><br>';

                $checkFields = false;
            }
    }

    if (isset($_POST['password'])) {

        $password = htmlspecialchars($_POST['password']);
                    
        
        if (strlen($password) < 3 || strlen($password) > 16) {
            
            $_SESSION['e_password'] = '<span style="color: red">Niewłaściwy format hasła.</span><br><br>';

            $checkFields = false;
        }

        if ( !isset($_POST['password2']) || $password != htmlspecialchars($_POST['password2'])) {
            $_SESSION['e_password2'] = '<span style="color: red">Hasła muszą być takie same.</span><br>';
            $checkFields = false;
        }

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
    }
    
    //Insert user to DB
    if ($checkFields == true) {
        
        $connect->query("INSERT INTO users VALUES (NULL, '$login', '$email', '$password_hashed') ");
        
        $connect->close();

        header('Location: index.php');

    }
    
    $connect->close();
    
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
            <small><span style="color: #666666;">Hasło musi mieć przynajmeniej 3 znaki. Max 16.</span></small><br>

            <?php
                if (isset($_SESSION['e_password'])) {
                    echo $_SESSION['e_password'];unset($_SESSION['e_password']);   
                }             
            ?>

            <br><label>Repeat Password</label><br>
            <input type="password" name="password2" placeholder="Password"><br>

            <?php
                if (isset($_SESSION['e_password2'])) {
                    echo $_SESSION['e_password2'];unset($_SESSION['e_password2']);   
                }             
            ?>

            <br>
            <button type="button"><a href="/sons/index.php">Anuluj</a></button>
            <button type="submit">Register</button>               

        </form>
    </body>

</html>