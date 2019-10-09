<?php

require_once('config.php');

if (isset($_POST['login'])) {
    
    $login = htmlspecialchars( $_POST['login'] );

    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    if ($connect->connect_errno != 0) {
        echo "We have a problem with Database connect. Contact with support.";
    }

    $loginQuery = $connect->query("SELECT * FROM users WHERE login='$login'");
    if (!$loginQuery) {
        throw new Exception($connect->error);
    }

    $row = $loginQuery->fetch_assoc();

    $passwordToVerify = $row['password'];

    $loginCheck = $loginQuery->num_rows;
    if ($loginCheck == 1) {
        
        $password = htmlspecialchars( $_POST['password'] );

        if (password_verify($password, $row['password']) == true) {
            echo "Hasło się zgadza. ZALOGOWANO do konta gracza " . $login;
        }
        else{
            echo "Login ok, ale hasło chujowe.";
        }

    }
    else{
        echo "Nie ma takiego chłopa w DB, albo coś się zjebało z hasłem";
    }


}

