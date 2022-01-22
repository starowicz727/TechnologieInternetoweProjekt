<?php

session_start();

if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

//jesli użytkownik sie zalogował 
echo "witaj w aplikacji ".$_SESSION["login"];

?>