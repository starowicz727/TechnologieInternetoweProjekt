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
/////////////////////////////2. wyswietlamy fiszki i odpowiedzi///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = " . $_SESSION["category_last_id"];
$result = $conn->query($sql);
if ($result == false) {
    echo "bledne polecenie sql" . $sql;
    exit;
} else {
    $questions = 0;
    $points = 0;
    $color = 'green'; ?>
    <div class="answer">
        <div class="container">
            <div class="answer__heading">
                <div class="answer__first" style="background-color: #A0CFEF;">
                    <span>Term Definition</span>
                </div>
                <div class="answer__second" style="background-color: #A0CFEF;">
                    <span>Definition</span>
                </div>
                <div class="answer__third" style="background-color: #A0CFEF;">
                    <span>Your Answer</span>
                </div>
            </div>
        </div>
    </div>
    <?php while (($rekord = $result->fetch_assoc()) != null):
        if ($rekord["definition"] == $_POST[$rekord["term"]]) {
            $points += 1;
            $color = '#B5E5AE';
        } else {
            $color = '#F29B9B';
        }
        $questions += 1; ?>
        <div class="answer">
            <div class="container">
                <div class="answer__wrapper">
                    <div class="answer__first" style="background-color: #f1f1f1">
                        <?= $rekord["term"]; ?>
                    </div>
                    <div class="answer__second" style="background-color: #f1f1f1">
                        <?= $rekord["definition"] ?>
                    </div>
                    <div class="answer__third" style="background-color: <?= $color ?>">
                        <?= $_POST[$rekord["term"]] ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <div class="answer">
        <div class="container">
            <div class="user-results">
                <div class="user-results__point">
                    Your points: <?= $points ?>
                </div>
                <div class="user-results__percents">
                    Total percentage of correct answers: <?= round($points / $questions * 100, 2) . " %" ?>
                </div>
                <div class="user-results__try-again">
                    <form action="sprawdzian.php" method="post">
                        <input type='hidden' name=categ_id value="<?= $_SESSION["category_last_id"] ?>">
                        <input type=submit value='Try again'>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="answer">
        <div class="container">
            <div class="learn-again">
                <form method=post action=ucz_sie.php>
                    <input type='hidden' name=categ_id value="<?= $_SESSION[" category_last_id"] ?>">
                    <input type=submit value='Learn again'>
                </form>
            </div>
        </div>
    </div>
<?php } ?>