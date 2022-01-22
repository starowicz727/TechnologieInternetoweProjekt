<?php
if(isset($_POST["re_login"]) && isset($_POST["re_pass"])) //jelsi rejestracja.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=?"; //sprawdzamy czy dany login jest zajęty
    $prep = $conn -> prepare($sql);
    $prep -> bind_param('s',$_POST['re_login']); 
    $prep -> execute(); // tu się wykona select
    $result = $prep -> get_result();

    if($row = $result -> fetch_assoc() != null){ // jeśli select nie zwrócił null => takie konto istnieje=> rejestracja nie powinna się udać
        echo"Podany login jest już zajęty :(";
        show_form();
    }
    else{ // login nie jest zajęty => tworzymy konto 
        $sql = "insert into users (login, password) values (?,?)";
        $prep = $conn -> prepare($sql);
        $hash_pass = sha1($_POST['re_pass']);
        $prep -> bind_param('ss',$_POST['re_login'], $hash_pass); 
        $result = $prep -> execute(); // tu się wykona insert
        if($result){//jeśli się udało
            echo "Konto zostało utworzone! Możesz się zalogować"; 
            echo "<form method=post action=logowanie.php>";
            echo "<input type=submit value='Powrót do logowania'>";
            echo "</form>";
            //header("Location: logowanie.php"); //tu przechodzimy do kolejnego skryptu
        }
    }
}
else{
    show_form();
}

function show_form(){
    echo "<form method=post action=rejestracja.php>";
    echo "<input name=re_login required=\"required\">Login</br>"; 
    echo "<input type=password name=re_pass required=\"required\">Haslo</br>";
    echo "<input type=submit value=Zarejestruj>";
    echo "</form>";

    echo "<a href=\"logowanie.php\">Powrót na stronę główną</a>";
}

?>