<?php
session_start();

require_once('config.php');
require_once('hero.php');

if (!$_SESSION['logged']) {
    header("Location: index.php");
}

$userID = $_SESSION['userid'];
$userLogin = $_SESSION['login'];

echo "Zalogowano do konta gracza " . "<span style='color: blue'><strong>$userLogin</strong></span> ". "<br><br>";

//Logout button
if (isset($_POST['logout-btn'])) {
    header("Location: index.php");
    session_destroy();
}


//Create a new character.

if (isset($_POST['test-btn'])) {

    echo '  
    <div class="character-form">
    <form action="app.php" method="POST">
    <h2>Stwórz postać</h2>
        <label>Imię postaci:</label><br>
        <input type="text" name="cname"><br><br>

        <label>Wybierz klasę</label><br>
        <select name="character-class""><br>
            <option value="warrior">Wojownik</option>
            <option value="wizard">Mag</option>
        </select>

        <br><br><button type="submit" name="oko">Stwórz!</button>
    
    </form></div>
';

    // if (isset($_POST['cname'])) {

    //     // echo "IMIE: ". $_POST['cname'];

    //     // $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    //     // $connect->query("UPDATE users SET hero=1 WHERE user_id=8 ");

    //     // header("Location: app.php");
    // }


}
else{

}


if (isset($_POST['cname'])) {

    // echo "IMIE: ". $_POST['cname'];

    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    $connect->query("UPDATE users SET hero=1 WHERE user_id='$userID' ");

    header("Location: app.php");
}


// $hero = new \Hero\Hero();

// if(isset($_POST['create-btn'])){
//     $fieldsOk = true;

//     if (!isset($_POST['character-name'])) {
//         $fieldsOk = false;
//         $_SESSION["e_name"] = '<span style="color: red">Podaj nazwę postaci</span>';
//     }
//     // $hero->setName($_POST['character-name']);
// }
// $_SESSION["e_name"] = '<span style="color: red">Podaj nazwę postaci</span>';







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

            $heroQuery = $connect->query("SELECT hero FROM users WHERE user_id='$userID'");

            $heroRow = $heroQuery->fetch_assoc();
            $heroStatus = $heroRow['hero'];

            if ($heroStatus == 0) {
               echo '<form action="app.php" method="POST">
               <button type="submit" name="test-btn">Stwórz postać</button>
               </form>'; 
            }
            else{
                echo '
                <button class="trigger">Pokaż postać</button>
                <form action="app.php" method="POST">
                <div class="modal">
                    <div class="modal-content">
                        <span class="close-button">×</span>
                        <h1>Postać</h1>

                        <p><strong>IMIE: </strong> Seq</p>
                        <p><strong>KLASA: </strong> Wojownik</p><br>
                        
                        <br><button type="submit" name="delete-btn"><span style="color: red">Usuń Postać</span></button>
                    </div>
                </div>
                </form>'; 
            }
           

            echo "STATUS: " . $heroStatus;
            echo "<br> USER ID = " . $userID;
         ?>       
                <!-- modal -->

        <div class="main-form">
        <form action="app.php" method="POST">
            <button type="submit" name="logout-btn">Logout</button>
            <!-- <button type="submit" name="db-btn">Dodaj do DB</button> -->
        </form>
        </div>

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