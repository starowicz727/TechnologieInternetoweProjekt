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

if (isset($_POST["frm_name_categ"])) //jelsi dodaj_kategorie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych
    $users_login = $_SESSION["login"];

    $sql = "insert into categories (name, user_login) values (?,?)";
    $prep = $conn->prepare($sql);
    $prep->bind_param('ss', $_POST['frm_name_categ'], $users_login);
    $result = $prep->execute(); // tu się wykona insert

    if ($result) {//jeśli się udało
        $last_id = $conn->insert_id; // metoda zwraca ID ostatnio dodanego rekordu
        $_SESSION["category_last_id"] = $last_id;        // zapisujemy w sesji ID kategorii którą przed chwilą dodaliśmy
        header("Location: dodaj_fiszki_do_kategorii.php"); //tu przechodzimy do kolejnego skryptu
    } else {
        show_categ_form();
    }
} else {
    show_categ_form();
}

function show_categ_form()
{ ?>
        <div class="new-folder">
            <div class="container">
                <form action="dodaj_kategorie.php" method="post">
                    <label for="frm_name_categ">Nazwa folderu</label>
                    <input class="new-folder-input" type="text" name="frm_name_categ" required>
                    <input class="new-folder-submit" type="submit" value="Stwórz">
                </form>
            </div>
        </div>
<?php } ?>


