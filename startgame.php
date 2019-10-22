<?php
session_start();
require_once('config.php');

$miasto = "Gdansk";

$jsonData = file_get_contents('https://api.openweathermap.org/data/2.5/weather?q=' . $miasto . '&units=metric&appid=cf833ea4d9b83ed6d740d22700d79d1b');

$json = json_decode($jsonData, true);

echo "City: " . $json['name'] . "<br>";
echo "Temp: " . $json['main']['temp'] . "<br>";

echo "<br><br>" . "GRAMY!";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>GRA</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">   
    </head>
    <body>

        <br>
        <a href="app.php">Menu główne</a>
    </body>
</html>