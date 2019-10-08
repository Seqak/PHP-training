<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Siema</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <h2>Home | </h2> <a href="register.php"><h3>Register now!</h3></a>
        <form action="login.php" method="POST">
            <input type="text" name="login" placeholder="Login"><br>
            <input type="password" name="password" placeholder="Password"><br><br>
            <button type="submit">Login</button>

        </form>

        
    </body>

</html>