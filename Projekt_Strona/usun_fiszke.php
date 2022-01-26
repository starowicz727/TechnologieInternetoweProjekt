<?php
session_start();
if (!isset($_SESSION["login"])) { //jesli użytkownik sie nie zalogował
    header("Location: logowanie.php");
    exit;
}

require_once("connect.php"); // łączymy się z bazą danych
$flashcrd_delete = $_GET["flashcard_delete_id"];

//usuwamy fiszke
$sql = "delete from flashcards where id=$flashcrd_delete";
$conn->query($sql);

//na koniec wracamy na strone folderu, z którego usunęliśmy fiszkę 
header("Location: dodaj_fiszki_do_kategorii.php");

?>