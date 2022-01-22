<?php

session_start();

if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

//jesli użytkownik sie zalogował 
echo "Cześć ".$_SESSION["login"];
echo "Twoje fiszki:";

echo "<form method=post action=dodaj_kategorie.php>";
echo "<input type=submit value='Stwórz nowy folder'>";
echo "</form>";



?>