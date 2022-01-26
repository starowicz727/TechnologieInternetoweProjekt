<?php
session_start();
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
    <!-- mozliwe ze bez tego shrink-to-fit=no -->

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

<div class="utility-form">
    <div class="container">
        <div class="utility-form__wrapper">
            <div class="utility-form__folder-name">
                <?= "folder: " . $c_name["name"]; ?>
            </div>
            <div class="utility-form__form">
                <form method=post action=dodaj_fiszki_do_kategorii.php>
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__label">
                            <label for="frm_flash_term">Term</label>
                        </div>
                        <div class="utility-form__form__single__input">
                            <input name=frm_flash_term required=\"required\">
                        </div>
                    </div>
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__label">
                            <label for="frm_flash_def">Definition</label>
                        </div>
                        <div class="utility-form__form__single__input">
                            <input name=frm_flash_def required=\"required\">
                        </div>
                    </div>
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__submit">
                            <input type=submit value=Add>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
/////////////////////////////1.najpierw wyswietlamy formularz ///////////////////////////////////////////////////


/////////////////////////////2. wyswietlamy fiszki ///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = " . $_SESSION["category_last_id"];
$wynik = $conn->query($sql);
if ($wynik == false) {
    echo "bledne polecenie sql" . $sql;
    exit;
} else { ?>
    <div class="terms">
        <div class="container">
            <div class="terms__heading">
                <h5>Term definition</h5>
            </div>
            <div class="terms__wrapper">
                <?php while (($rekord = $wynik->fetch_assoc()) != null): ?>
                    <div class="terms__single">
                        <div class="terms__single__title">
                            <?= $rekord["term"] ?>
                        </div>
                        <div class="terms__single__definition">
                            <?= $rekord["definition"] ?>
                        </div>
                        <div class="terms__single__edit">
                            <form method=post action=edytuj_fiszke.php>
                                <input type='hidden' name=flashcard_id value="<?= $rekord['id'] ?>">
                                <input type=submit value='Edit'>
                            </form>
                        </div>
                        <div class="terms__single__delete">
                            <?php
                            echo "<td><a href=usun_fiszke.php?flashcard_delete_id=$rekord[id]>";
                            echo "<img alt=\"delete\" src=\"img/delete-button.png\">";
                            echo "</a>";
                            ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <?php
    {
        //echo "<td><a href=edytuj_fiszke.php?flashcard_id=$rekord[id]>edytuj</a>"; //tu przesyłamy id fiszki
    }
}

/////////////////////////////3. dodajemy fiszki ///////////////////////////////////////////////////
if (isset($_POST["frm_flash_term"]) && isset($_POST["frm_flash_def"])) //jelsi dodaj_fiszki_do_kategorii.php nie byl uruchomiony po raz pierwszy
{
    $sql = "insert into flashcards (term, definition,category_id) values (?,?,?)";
    $prep = $conn->prepare($sql);
    $prep->bind_param('ssi', $_POST['frm_flash_term'], $_POST['frm_flash_def'], $_SESSION["category_last_id"]);
    $result = $prep->execute(); // tu się wykona insert
    if ($result) {//jeśli się udało
        # header("Location: dodaj_fiszki_do_kategorii.php"); //tu załadujemy stronę od nowa, żeby wyświetlić dodaną fiszkę
        echo "	<script type='text/javascript'>
					window.location.href = 'dodaj_fiszki_do_kategorii.php';
					</script>";
    } else {
        echo "błąd dodania fiszki";
    }
}

//////////////////////4. mozliwosc usuniecia calego folderu z fiszkami /////////////////
?>

<div class="delete-flashcard">
    <div class="container">
        <div class="delete-flashcrad__wrapper">
            <form method=post action=usun_kategorie.php>
                <input type='hidden' name=cat_delete value="<?= $_SESSION["category_last_id"] ?>">
                <input type=submit value='Usuń ten folder'>
            </form>
        </div>
    </div>
</div>