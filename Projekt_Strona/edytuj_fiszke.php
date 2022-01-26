<!DOCTYPE html>
<html lang="pl">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- mozliwe ze bez tego shrink-to-fit=no -->

    <title>Flashcards</title>
    <meta name="description" content="Flashcards site">
    <meta name="keywords" content="flashcards, learning">
    <meta name="author" content="Dawid Czerwieński, Patrycja Piątek, Maria Starowicz">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">

</head>

<body>

<header>
    <nav class="navbar navbar-custom navbar-expand-md">
        <a style="color: #ffffff" class="navbar-brand" href="logowanie_ok.php">
            <img src="img/logo.png" width="30" height="30"
                 class="d-inline-block mr-1 align-bottom"
                 alt="">Flashcards.com</a>
        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false"
                aria-label="Przełącznik nawigacji">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainmenu">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a style="color: #ffffff" class="nav-link" href="logowanie_ok.php"> Home </a>
                </li>
                <li class="nav-item disable">
                    <a style="color: #ffffff" class="nav-link" href="profile.php"> Profile </a>
                </li>
                <li class="nav-item disable">
                    <a style="color: #ffffff" class="nav-link" href="LogOut.php"> Log out </a>
                </li>
            </ul>
    </nav>
</header>

<script src="js/bootstrap.min.js"></script>

</body>
</html>


<?php
session_start();
require_once("connect.php"); // łączymy się z bazą danych
$flashcard_id = $_POST["flashcard_id"];
echo $flashcard_id;
$flashc_term = "";
$flashc_def = "";
$category_id = ""; // potrzebne żeby znowu wrócić do widoku folderu z już wyedytowaną fiszką
/////////////////////////////1. szukamy informacji jak póki co wygląda fiszka///////////////////////////////////
$sql = "SELECT term,definition,category_id FROM flashcards WHERE id = " . $flashcard_id;
$wynik = $conn->query($sql);
if ($wynik == false) {
    echo "bledne polecenie sql" . $sql;
    exit;
} else {
    $wynik = $wynik->fetch_assoc();
    $flashc_term = $wynik["term"];
    $flashc_def = $wynik["definition"];
    $category_id = $wynik["category_id"];
}

echo "<form method=post action=edytuj_fiszke.php>";
echo "<input name=frm_flash_term value=" . $flashc_term . " required=\"required\">Term</br>";
echo "<input name=frm_flash_def value=" . $flashc_def . " required=\"required\">Definition</br>";
echo "<input type='hidden' name=flashcard_id value=" . $flashcard_id . ">";
echo "<input type=submit value=Edit>";
echo "</form>";

if (isset($_POST["frm_flash_term"]) && isset($_POST["frm_flash_def"])) {
    $sql = "update flashcards set term=?, definition=? where id=?";
    $prep = $conn->prepare($sql);
    $prep->bind_param('ssi', $_POST['frm_flash_term'], $_POST['frm_flash_def'], $flashcard_id);
    $prep->execute(); // tutaj wykona się update
    //$_SESSION["category_last_id"] = $category_id;
    header("Location: dodaj_fiszki_do_kategorii.php"); //tu wracamy do widoku całego folderu, korzystamy z tego skryptu a nie z dodaj_fiszki_do_kategorii, żeby nie używać get
}

?>