<?php
if(isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //jelsi logowanie.php nie byl uruchomiony po raz pierwszy
{
    if(($_POST["frm_login"]=="a") && ($_POST["frm_pass"]=="a")){ //select*from xyz where login=frm_login and password=frm_pass
        //echo "udalo sie zalogowac";
        session_start();
        $_SESSION["login"]= $_POST["frm_login"];
        header("Location: logowanie_ok.php"); //tu przechodzimy do kolejnego skryptu
    }
    else{
        echo "nie udalo sie";
    }
}

echo "<form method=post action=logowanie.php>";
echo "<input name=frm_login>Login</br>"; //login moze byc primary key
echo "<input type=password name=frm_pass>Haslo</br>";
echo "<input type=submit value=Logowanie>";
echo "</form>";

echo "<a href=\"rejestracja.php\">Nie masz konta? Zarejestruj się</a>";

?>