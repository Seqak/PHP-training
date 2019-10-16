<?php
session_start();

require_once('config.php');
require_once('hero.php');

if (!$_SESSION['logged']) {
    header("Location: index.php");
}

$userID = $_SESSION['userid'];
$userLogin = $_SESSION['login'];
$herofkId1 = $_SESSION['herofkid'];

echo "Zalogowano do konta gracza " . "<span style='color: blue'><strong>$userLogin</strong></span> ". "<br><br>";

//Logout button
if (isset($_POST['logout-btn'])) {
    header("Location: index.php");
    session_destroy();
}


//Create a new character.

if (isset($_POST['create-hero-btn'])) {

    echo '  
    <div class="character-form">

    <form action="app.php" method="POST">
    <button class="close-btn" type="submit">X</button>
    </form>
    
    <form action="app.php" method="POST">
    <h2>Stwórz postać</h2>
        <label>Imię postaci:</label><br>
        <input type="text" name="hero-name"><br>
        <?php
        if (isset($_SESSION[""e_hero_name""])) {
            echo $_SESSION["e_hero_name"];unset($_SESSION["e_hero_name"]);
        }
    ?>
    <br>

        <label>Wybierz klasę</label><br>
        <select name="hero-class-select""><br>
            <option value="warrior">Wojownik</option>
            <option value="wizard">Mag</option>
        </select>

        <br><br><button type="submit" name="add-hero-btn">Stwórz!</button>
    
    </form></div>';
}


if (isset($_POST['hero-name'])) {

    $heroName = htmlspecialchars($_POST['hero-name']);
    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    $heroNameQuery = $connect->query("SELECT hero_id FROM hero WHERE name='$heroName'");

    $heroNameResult = $heroNameQuery->num_rows;
    echo "Ilość rezultów " . $heroNameResult;
    if ($heroNameResult > 0) {
        $_SESSION["e_hero_name"] = '<span style="color: red">Podana nazwa już jest zajęta.</span><br>';

        echo '  
    <div class="character-form">

    <form action="app.php" method="POST">
    <button class="close-btn" type="submit">X</button>
    </form>
    
    <form action="app.php" method="POST">
    <h2>Stwórz postać</h2>
        <label>Imię postaci:</label><br>
        <input type="text" name="hero-name"><br>
        '. $_SESSION["e_hero_name"]. '
    <br>

        <label>Wybierz klasę</label><br>
        <select name="hero-class-select""><br>
            <option value="warrior">Wojownik</option>
            <option value="wizard">Mag</option>
        </select>

        <br><br><button type="submit" name="add-hero-btn">Stwórz!</button>
    
    </form></div>';
    }
    else{

        if (isset($_POST['hero-class-select'])) {
            $heroClass = $_POST['hero-class-select'];  
        }
        
        $connect->query("INSERT INTO hero VALUES (NULL, '$heroName', '$heroClass', 10, 10, 0, 1)");

        $heroFkQuery = $connect->query("SELECT hero_id FROM hero WHERE name='$heroName'");
        $heroFkResult = $heroFkQuery->fetch_assoc();
        $heroFkId = $heroFkResult['hero_id'];
        $connect->query("UPDATE users SET hero=1, hero_id='$heroFkId' WHERE user_id='$userID' ");

        //Rozwiązanie problemu: Zrobienie zmiennej sesyjnej, ustawienie jej i unset!!!
    }    
}else{

}

echo "ID hero test: " . $herofkId1;

//Display info about a created character.

if (isset($_POST['hero-info-btn'])) {

    

    //$heroFkId = $_SESSION['a'];
    // $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    // $heroInfoQuery = $connect->query("SELECT * FROM hero WHERE hero_id='$heroFkId'");
    // $heroInfoResult = $heroInfoQuery->fetch_assoc();

    //var_dump($heroInfoResult);

    //echo $_SESSION['testid'];

    echo ' 
    <div class="character-form">

    <form action="app.php" method="POST">
    <button class="close-btn" type="submit">X</button>
    </form>

    <form action="app.php" method="POST">
    <h2>Postać</h2>
    <strong>Nazwa: </strong> Seq <br><br>
    <strong>Klasa: </strong> Wojownik<br><br>
            <br><button type="submit" name="delete-hero-btn"><span style="color: red">Usuń Postać</span></button>
        </div>
    </div>
    </form>';

    
}


if (isset($_POST['delete-hero-btn'])) {
    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    $connect->query("UPDATE users SET hero=0 WHERE user_id='$userID' ");
}





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
               <button type="submit" name="create-hero-btn">Stwórz postać</button>
               </form>'; 
            }
            else{
                echo '
                <form action="app.php" method="POST">
                <button name="hero-info-btn" class="trigger" >Pokaż postać</button>
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