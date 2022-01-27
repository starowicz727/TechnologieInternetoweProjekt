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
                <li class="nav-item disabled">
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
if (!isset($_SESSION["login"])) { //jesli użytkownik sie nie zalogował
    header("Location: logowanie.php");
    exit;
}

if ($_SESSION["category_last_id"] == -1) { //gdy weszliśmy na te stronę z poziomu logowanie_ok
    $_SESSION["category_last_id"] = $_POST["categ_id"];
}

require_once("connect.php"); // łączymy się z bazą danych

/////////////////////////////0.na górze strony wyświetlamy nazwę folderu///////////////////////////////////
$sql = "SELECT name FROM categories WHERE id = " . $_SESSION["category_last_id"];
$wynik = $conn->query($sql);
if ($wynik == false) {
    echo "bledne polecenie sql" . $sql;
    exit;
} else {
    $c_name = $wynik->fetch_assoc();
} ?>

<div class="touchstone">
    <div class="container">
        <div class="utility-form__folder-name">
            folder: <?= $c_name["name"] ?>
        </div>
    </div>
</div>


<?php
/////////////////////////////2. wyswietlamy fiszki ///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = " . $_SESSION["category_last_id"];
$result = $conn->query($sql);
if ($result == false) {
    echo "bledne polecenie sql" . $sql;
    exit;
} else {
	$index=0;
    if (($rekord = $result->fetch_assoc()) != null) { //jesli mamy chociaz jedna fiszke 
		
	?>
       
	   <div class="touchstone">
            <div class="container">
                <div class="touchstone__form">
                    <form action="sprawdzian_sprawdz.php" method="post" autocomplete="off">
                        <div class="touchstone__heading">
                            <h4>Term Definition</h4>
                        </div>
                        <div class="touchstone__quiz">
                            <span><?= $rekord["term"] ?></span>
                            <input type=text name="<?= $index ?>" required="required">
                        </div>
                        <?php 
						$index +=1;
						while (($rekord = $result->fetch_assoc()) != null): ?>
                            <div class="touchstone__quiz">
                                <span><?= $rekord["term"] ?></span>
                                <input type=text name="<?= $index ?>" required="required">
                            </div>
                        <?php 
						$index +=1;
						endwhile; ?>
                        <div class="touchstone__quiz__submit">
                            <input type=submit value=Check>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="touchstone">
            <div class="container">
                <div class="touchstone__error">
                    <p style="text-align: center;">To create a quiz, you first need to add flashcards to this folder</p>
                </div>
            </div>
        </div>
    <?php }
} ?>

