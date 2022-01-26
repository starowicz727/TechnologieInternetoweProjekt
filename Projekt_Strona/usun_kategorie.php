<?php //tutaj nie potrzebujemy wyglądu strony
session_start();
if (!isset($_SESSION["login"])) { //jesli użytkownik sie nie zalogował
    header("Location: logowanie.php");
    exit;
}

// aby usunac kategorie => najpierw musimy usunac fiszki z niej 
require_once("connect.php"); // łączymy się z bazą danych
$category_delete = $_POST["cat_delete"];

//najpierw usuwamy fiszki
$sql = "delete from flashcards where category_id=$category_delete";
$conn->query($sql);
//potem usuwamy cały folder 
$sql = "delete from categories where id=$category_delete";
$conn->query($sql);
//na koniec wracamy na strone glowna logowanie_ok
header("Location: logowanie_ok.php");

?>