<?php
session_start();

require_once("connect.php");


$sql = "SELECT * FROM flashcards WHERE category_id = " . $_SESSION["category_last_id"];
$wynik = $conn->query($sql);
$string = "";
$array = array();
while (($rekord = $wynik->fetch_assoc()) != null) {

    array_push($array, array($rekord["term"], $rekord["definition"]));

}

$out = array_values($array);
echo json_encode($out);

?>