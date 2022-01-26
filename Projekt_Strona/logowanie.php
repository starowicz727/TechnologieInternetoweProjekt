<?php
session_start();
if (isset($_SESSION["login"])) { //jesli użytkownik sie już wcześniej zalogował
    header("Location: logowanie_ok.php");
    exit;
}
?>
<?php

if (isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //jeślii logowanie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=? and password=?";
    $prep = $conn->prepare($sql);
    $hash_pass = sha1($_POST['frm_pass']);
    $prep->bind_param('ss', $_POST['frm_login'], $hash_pass);
    $prep->execute(); // tu się wykona select
    $result = $prep->get_result();

    if ($row = $result->fetch_assoc() != null) { // jeśli select nie zwrócił null => takie konto istnieje=> logowanie powinno się udać
        //session_start();
        $_SESSION["login"] = $_POST["frm_login"];
        header("Location: logowanie_ok.php"); //tu przechodzimy do kolejnego skryptu
    }
    // else{
    //     //echo "";
    //     //$_POST["frm_login"] = "hfbsbf";
    //
    //     //echo "<br><h1 class=\"text-center text-danger\">Invalid username or password</h1>";
    // }
}
?>

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
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-custom navbar-expand-md">
        <a style="color: #ffffff" class="navbar-brand" href="#">
            <img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt="">Flashcards.com</a>
    </nav>

</header>
<div class="wrapper">
    <div class="container">
        <h1>Welcome</h1>
        <form id="login-form" class="form" action="logowanie.php" method="post">
            <input type="text" name="frm_login" id="username" required="required" placeholder="Username">
            <input type="password" name="frm_pass" id="password" required="required" placeholder="Password">
            <button type="submit" name="submit" id="login-button">Login</button>
            <br>
            <br>
            <div id="register-link">
                <a href="rejestracja.php">Don't have an account? <b>Register here</b></a>
            </div>
        </form>
    </div>

    <ul class="bg-bubbles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php

if (isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //jeślii logowanie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=? and password=?";
    $prep = $conn->prepare($sql);
    $hash_pass = sha1($_POST['frm_pass']);
    $prep->bind_param('ss', $_POST['frm_login'], $hash_pass);
    $prep->execute(); // tu się wykona select
    $result = $prep->get_result();

    if (!($row = $result->fetch_assoc() != null)) { // jeśli select nie zwrócił null => takie konto istnieje=> logowanie powinno się udać
        ?><br><h2>Invalid username or password</h2><?php
    }
    // else{
    //     //echo "";
    //     //$_POST["frm_login"] = "hfbsbf";
    //
    //     //echo "<br><h1 class=\"text-center text-danger\">Invalid username or password</h1>";
    // }
}
?>

