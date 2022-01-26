<?php

session_start();
$_SESSION["category_last_id"] = -1; //na początku nie wybralismy zadnego folderu

if (!isset($_SESSION["login"])) { //jesli użytkownik sie nie zalogował
    header("Location: logowanie.php");
    exit;
}
?>

    <!DOCTYPE html>
    <html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Flashcards</title>
        <meta name="description" content="Flashcards site">
        <meta name="keywords" content="flashcards, learning">
        <meta name="author" content="Dawid Czerwieński, Patrycja Piątek, Maria Starowicz">
        <meta http-equiv="X-Ua-Compatible" content="IE=edge">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="logowanie_ok_style.css">
        <link rel="stylesheet" href="main.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    </head>
    <body>
    <header>
        <nav class="navbar navbar-custom navbar-expand-md">
            <a style="color: #ffffff" class="navbar-brand" href="#">
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
        </nav>
    </header>
    <section>
        <div class='container'>
            <div class="flashcards-general">
                <div class="flashcards-general__heading">
                    <h1>Hello <?php echo $_SESSION["login"]; ?></h1>
                </div>
                <div class="flashcards-general__your-flashcards">
                    <h1>Your flashcards:</h1>
                </div>
                <div class="flashcards-general__form">
                    <form method=post action=dodaj_kategorie.php>
                        <?php show_folders(); ?><br>
                        <form action="dodaj_kategorie.php" method="post">
                            <input type=submit value='Create a new folder'>
                        </form>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="js/bootstrap.min.js"></script>
    </body>
    </html>
<?php

// //jesli użytkownik sie zalogował
// echo "Cześć ".$_SESSION["login"];
// echo "Twoje fiszki:";
// show_folders();

// echo "<form method=post action=dodaj_kategorie.php>";
// echo "<input type=submit value='Stwórz nowy folder'>";
// echo "</form>";

function show_folders()
{ //wyświetla wszystkie foldery fiszek == wszystkie kategorie
    require_once("connect.php"); // łączymy się z bazą danych

    $users_login = $_SESSION["login"];
    //$sql = "SELECT * FROM categories WHERE categories.user_login = \"$users_login \"";
    $sql = "SELECT * FROM categories WHERE user_login = \"$users_login \"";
    $wynik = $conn->query($sql);
    if ($wynik == false) {
        echo "bledne polecenie sql" . $sql;
        exit;
    }

    echo '<div class="flashcards">';
    while (($rekord = $wynik->fetch_assoc()) != null) { ?>
        <div class="flashcards__row">
            <div class="flashcards__row__folder"><?= $rekord['name'] ?></div>
            <div class="flashcards__row__actions">
                <div class="flashcards__row__actions__single">
                    <form method=post action=dodaj_fiszki_do_kategorii.php>
                        <input type='hidden' name=categ_id value="<?= $rekord['id'] ?>">
                        <input type='hidden' name=categ_id value="<?= $rekord['id'] ?>">
                        <input type=submit value='Edit this folder'>
                    </form>
                </div>
                <div class="flashcards__row__actions__single">
                    <form method=post action=ucz_sie.php>
                        <input type='hidden' name=categ_id value=" <?= $rekord['id'] ?>">
                        <input type=submit value='Learn'>
                    </form>
                </div>
                <div class="flashcards__row__actions__single">
                    <form method=post action=sprawdzian.php>
                        <input type='hidden' name=categ_id value=" <?= $rekord['id'] ?>">
                        <input type=submit value='Test'>
                    </form>
                </div>
            </div>
        </div>
    <?php }
    echo "</div>";
} ?>