<?php
session_start();

require_once('config.php');
require_once('hero.php');

if (!$_SESSION['logged']) {
    header("Location: index.php");
}

$userID = $_SESSION['userid'];
$userLogin = $_SESSION['login'];
//$herofkId1 = $_SESSION['herofk'];

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
        $_SESSION['herofk'] = $heroFkId;
    }    
}else{

}

//Display info about a created character.

if (isset($_POST['hero-info-btn'])) {

    $heroFkId = $_SESSION['herofk'];
    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    $heroInfoQuery = $connect->query("SELECT * FROM hero WHERE hero_id='$heroFkId'");
    $heroInfoResult = $heroInfoQuery->fetch_assoc();

    $heroName = $heroInfoResult['name'];
    if ($heroInfoResult['class'] == "warrior") {
        $heroClass = "Wojownik";
    }
    else{
        $heroClass = "Mag";
    }
    $heroHp = $heroInfoResult['hp'];
    $heroPower = $heroInfoResult['power'];
    $heroExp = $heroInfoResult['exp'];
    $heroLevel = $heroInfoResult['level_id'];

    echo ' 
    <div class="character-form">

    <form action="app.php" method="POST">
    <button class="close-btn" type="submit">X</button>
    </form>

    <form action="app.php" method="POST">
    <h2>Postać</h2>
    <strong>Imię: </strong> ' . $heroName . '<br>
    <strong>Klasa: </strong> ' . $heroClass . '<br><br>
    <strong>HP: </strong> ' . $heroHp . '<br>
    <strong>Siła: </strong> ' . $heroPower . '<br>
    <strong>EXP: </strong> ' . $heroExp . '<br>
    <strong>Poziom: </strong> ' . $heroLevel . '<br><br>

            <br><button type="submit" name="delete-hero-btn" class="delete-hero-class"><span style="color: red">Usuń Postać</span></button>
        </div>
    </div>
    </form>';

    
}

//Delete hero

if (isset($_POST['delete-hero-btn'])) {
    $connect = @new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
    $heroid = $_SESSION['herofk'];

    $connect->query("UPDATE users SET hero=0, hero_id=NULL WHERE user_id='$userID' ");
    $connect->query("DELETE FROM hero WHERE hero_id='$heroid'");
    unset($_SESSION['herofk']);
}

if (isset($_SESSION['herofk'])) {
    if ($_SESSION['herofk'] != NULL) {
        echo '  <form action="startgame.php" method="POST">
                    <button type="submit">Rozpocznij grę!</button>
                </form>';
    }
}


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
         ?>       
                <!-- modal -->

        <div class="main-form">
        <form action="app.php" method="POST">
            <button type="submit" name="logout-btn">Logout</button>
        </form>
        </div>
        
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