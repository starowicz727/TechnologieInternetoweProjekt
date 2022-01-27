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
                <li class="nav-item disable">
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
<div class="utility-form">
    <div class="container">
        <div class="utility-form__wrapper">
            <!-- <div class="utility-form__folder-name">
               
            </div> -->
            <div class="utility-form__form">
                <form form id="login-form" class="form" action="zmien_haslo.php" method="post">
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__label">
                            <label for="frm_flash_term">New password</label>
                        </div>
                        <div class="utility-form__form__single__input">
                            <!-- <input name=frm_flash_term required=\"required\"> -->
                            
                            <input type="password" name="frm_pass1" id="username" required="required">
                        </div>
                    </div>
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__label">
                            <label for="frm_flash_def">Repeat password</label>
                        </div>
                        <div class="utility-form__form__single__input">
                            <!-- <input name=frm_flash_def required=\"required\"> -->
                            
                            <input type="password" name="frm_pass2" id="password" required="required">
                        </div>
                    </div>
                    <div class="utility-form__form__single">
                        <div class="utility-form__form__single__submit">
                            <input type="submit" name="submit" value="Reset">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php

session_start();

if (!isset($_SESSION["login"])) { //jesli użytkownik sie nie zalogował
    header("Location: logowanie.php");
    exit;
}

if (isset($_POST["frm_pass1"]) && isset($_POST["frm_pass2"])) //jeślii zmien_haslo.php nie byl uruchomiony po raz pierwszy
{
if ($_POST["frm_pass1"] == $_POST["frm_pass2"]){
    require_once("connect.php"); // łączymy się z bazą danych
    $sql = "update users set password=? where login=?";
    $prep = $conn->prepare($sql);
    $new_passw = sha1($_POST['frm_pass1']);
    $prep->bind_param('ss', $new_passw, $_SESSION["login"]);
    $prep->execute(); // tutaj wykona się update
    header("Location: profile.php"); //tu wracamy do przeglądania profilu
}
else{
echo "<h1 class=\"text-center text-danger\">Both passwords must be the same</h1>";
?>
<body style="background:#632525;"><?php
}
}

?>
<script src="js/bootstrap.min.js"></script>

</body>
</html>