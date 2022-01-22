<?php

if(isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //jeślii logowanie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=? and password=?";
    $prep = $conn -> prepare($sql);
    $hash_pass = sha1($_POST['frm_pass']);
    $prep -> bind_param('ss',$_POST['frm_login'], $hash_pass); 
    $prep -> execute(); // tu się wykona select
    $result = $prep -> get_result();

    if($row = $result -> fetch_assoc() != null){ // jeśli select nie zwrócił null => takie konto istnieje=> logowanie powinno się udać
        session_start();
        $_SESSION["login"]= $_POST["frm_login"];
        header("Location: logowanie_ok.php"); //tu przechodzimy do kolejnego skryptu
    }
    else{
        echo"Błąd logowania"; //tu wracamy do ponownego logowania, bo nie udało się zalogować
    }
}

echo "<form method=post action=logowanie.php>";
echo "<input name=frm_login required=\"required\">Login</br>"; 
echo "<input type=password name=frm_pass required=\"required\">Haslo</br>";
echo "<input type=submit value=Logowanie>";
echo "</form>";

echo "<a href=\"rejestracja.php\">Nie masz konta? Zarejestruj się</a>";

?>