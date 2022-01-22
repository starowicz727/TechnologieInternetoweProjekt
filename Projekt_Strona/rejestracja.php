<?php
if(isset($_POST["re_login"]) && isset($_POST["re_pass"])) //jelsi rejestracja.php nie byl uruchomiony po raz pierwszy
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
echo "<input name=re_login required=\"required\">Login</br>"; //login moze byc primary key
echo "<input type=password name=re_pass required=\"required\">Haslo</br>";
echo "<input type=submit value=Zarejestruj>";
echo "</form>";

?>