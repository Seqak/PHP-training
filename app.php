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


//Create a new character.

//Display info about a created character.


?>

<!DOCTYPE html>
<html>
    <head>
        <title>GRA</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">

       
    </head>

    <body>
                <!-- modal -->
         <?php

         //Check if character is already created.
            $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

            if ($connect->connect_errno != 0) {
                echo "We have a problem with Database connect. Contact with support.";
            }

            $heroQuery = $connect->query("SELECT hero FROM users WHERE userid='$userID'");

            $heroRow = $heroQuery->fetch_assoc();
            $heroStatus = $heroRow['hero'];

            if ($heroStatus == 0) {
                echo '<button class="trigger">Stwórz postać</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h1>Postać</h1>
        
                        <form action="app.php" method="POST">
                            <label>Imię postaci:</label><br>
                            <input type="text" name="character-name"><br><br>
        
                            <label>Wybierz klasę</label><br>
                            <select name="character-class""><br>
                                <option value="warrior">Wojownik</option>
                                <option value="wizard">Mag</option>
                            </select>
        
                            <br><br><button type="submit">Stwórz!</button>
                        </form>
                    </div>
                </div>'; 
            }
            else{
                echo '<button class="trigger">Pokaż postać</button>
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h1>Postać</h1>

                        <p><strong>IMIE: </strong> Seq</p>
                        <p><strong>KLASA: </strong> Wojownik</p><br>
                        
                        <br><button type="submit"><span style="color: red">Usuń Postać</span></button>
                    </div>
                </div>'; 
            }
           

            
         ?>       
                <!-- modal -->

        <form action="app.php" method="POST">
            <button type="submit" name="logout-btn">Logout</button>
        </form>

        <script src="main.js"> </script>
    </body>
</html>



<!-- TO DO 
*
*Stworzyć tabelę w DB - a) Character b) Level
*
*Dodawanie postaci
*
*Profil utworzonej postaci
*
*Koncepcja na robienie save'ów
*
-->