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
</head>

<body>
<header>

<header>
    <nav class="navbar navbar-custom navbar-expand-md">
        <a style="color: #ffffff" class="navbar-brand" href="#">
            <img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt="">Flashcards.com</a>
    </nav>

</header>



<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php
if (isset($_POST["re_login"]) && isset($_POST["re_pass"])) //jelsi rejestracja.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=?"; //sprawdzamy czy dany login jest zajęty
    $prep = $conn->prepare($sql);
    $prep->bind_param('s', $_POST['re_login']);
    $prep->execute(); // tu się wykona select
    $result = $prep->get_result();

    if ($row = $result->fetch_assoc() != null) { // jeśli select nie zwrócił null => takie konto istnieje=> rejestracja nie powinna się udać
        ?><h2><br>The given login is already taken :(</h2>
        <?php
        //echo"The given login is already taken :(";
        show_form();
    } else { // login nie jest zajęty => tworzymy konto
        $sql = "insert into users (login, password) values (?,?)";
        $prep = $conn->prepare($sql);
        $hash_pass = sha1($_POST['re_pass']);
        $prep->bind_param('ss', $_POST['re_login'], $hash_pass);
        $result = $prep->execute(); // tu się wykona insert
        if ($result) {//jeśli się udało
            ?><h1><br>Account has been created! You can log in</h1><?php
            // echo "Account has been created! You can log in";
            echo "<form method=post action=logowanie.php>";
            echo "<input type=submit value='Back to the login page'>";
            echo "</form>";
            //header("Location: logowanie.php"); //tu przechodzimy do kolejnego skryptu
        }
    }
} else {
    show_form();
}

function show_form()
{
    ?>
    <div class="login-wrapper">
        <div class="container">
            <h1>Registration</h1>

            <form id="register-form" class="form" action="rejestracja.php" method="post">
                <input type="text" name="re_login" id="username" required="required" placeholder="Username">
                <input type="password" name="re_pass" id="password" required="required" placeholder="Password">
                <button type="submit" name="register" id="register-button">Register</button>
                <br>
                <br>
                <div id="register-link">
                    <a href="logowanie.php">Back to the login page</a>
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

    <?php
    // echo "<form method=post action=rejestracja.php>";
    // echo "<input name=re_login required=\"required\">Login</br>";
    // echo "<input type=password name=re_pass required=\"required\">Haslo</br>";
    // echo "<input type=submit value=Zarejestruj>";
    // echo "</form>";

    // echo "<a href=\"logowanie.php\">Powrót na stronę główną</a>";
}

?>