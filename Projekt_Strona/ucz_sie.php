<?php
session_start();
if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

if($_SESSION["category_last_id"]==-1){ //gdy weszliśmy na te stronę z poziomu logowanie_ok
    $_SESSION["category_last_id"] = $_POST["categ_id"];
}

require_once("connect.php"); // łączymy się z bazą danych

/////////////////////////////0.na górze strony wyświetlamy nazwę folderu///////////////////////////////////
$sql = "SELECT name FROM categories WHERE id = ". $_SESSION["category_last_id"];
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
    $c_name = $wynik -> fetch_assoc();
}
echo "folder: ".$c_name["name"];

/////////////////////////////1. wyswietlamy fiszki ///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = ". $_SESSION["category_last_id"];
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
    echo "<table border><th>Term<th>Definition";
    while(($rekord = $wynik -> fetch_assoc()) != null) // wyświetlamy istniejące fiszki 
    {
        echo "<tr><td>".$rekord["term"];
        echo "<td>".$rekord["definition"];
    }
    echo "</table>";
}

    



?>