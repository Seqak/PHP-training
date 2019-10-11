<?php
session_start();

require_once('config.php');

if (isset($_POST['submit-btn']) && empty($_POST['login'])) {
    $_SESSION['e_login'] = '<span style="color: red">Podaj login ciulu.</span><br>';
}
elseif (isset($_POST['login'])) {
    
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
            header("Location: app.php");

            $_SESSION['id'] = $row['userid'];
            $_SESSION['login'] = $row['login'];
            $_SESSION['logged'] = true;

            $connect->close();
            exit();
        }
        else{
            $_GET['login'] = $login;
            $_SESSION['e_password'] = '<span style="color: red">Błędne hasło.</span><br>';
        }

    }
    else{    
        $_SESSION['e_login'] = '<span style="color: red">Brak użytkownika o takim loginie.</span><br>';
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Siema</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h2>Home | </h2> <a href="register.php"><h3>Register now!</h3></a>
        <form action="index.php" method="POST">
            <label>Login</label><br>
            <input type="text" name="login" placeholder="Login"><br>
            <?php
            if (isset($_SESSION['e_login'])) {
                echo $_SESSION['e_login'];unset($_SESSION['e_login']);
            }
            ?><br>
            <label>Password</label><br>
            <input type="password" name="password" placeholder="Password"><br>
            <?php
                if (isset($_SESSION['e_password'])) {
                    echo $_SESSION['e_password'];unset($_SESSION['e_password']);   
                }             
            ?><br>
            <button type="submit" name="submit-btn">Login</button>

        </form>

        
    </body>

</html>