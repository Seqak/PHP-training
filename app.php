<?php
session_start();
require_once('config.php');

if (!$_SESSION['logged']) {
    header("Location: index.php");
}

$userID = $_SESSION['id'];
$userLogin = $_SESSION['login'];

echo "Zalogowano do konta gracza " . "<span style='color: blue'><strong>$userLogin</strong></span> ". "<br><br>";


if (isset($_POST['logout-btn'])) {
    header("Location: index.php");
    session_destroy();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>GRA</title>
        <meta charset="UTF-8">
    </head>

    <body>
    <form action="app.php" method="POST">
        <button type="submit" name="logout-btn">Logout</button>
    </form>

    </body>
</html>