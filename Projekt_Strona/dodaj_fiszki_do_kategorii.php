<?php
session_start();

if(!isset($_SESSION["category_last_id"])){
    $_SESSION["category_last_id"] = $_POST["categ_id"];
}

require_once("connect.php"); // łączymy się z bazą danych

/////////////////////////////0.na górze strony wyświetlamy nazwę folderu///////////////////////////////////
$sql = "SELECT name FROM categories WHERE id = ". $_SESSION["category_last_id"];
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
    $c_name = $wynik -> fetch_assoc();
}
echo "folder: ".$c_name["name"];

/////////////////////////////1.najpierw wyswietlamy formularz ///////////////////////////////////////////////////
echo "<form method=post action=dodaj_fiszki_do_kategorii.php>";
echo "<input name=frm_flash_term required=\"required\">Term</br>"; 
echo "<input name=frm_flash_def required=\"required\">Definition</br>"; 
echo "<input type=submit value=Add>";
echo "</form>";

/////////////////////////////2. wyswietlamy fiszki ///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = ". $_SESSION["category_last_id"];
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
    echo "<table border><th>Term<th>Definition<th><th>";
    while(($rekord = $wynik -> fetch_assoc()) != null) // wyświetlamy istniejące fiszki 
    {
        echo "<tr><td>".$rekord["term"];
        echo "<td>".$rekord["definition"];
        //echo "<td><a href=edytuj_fiszke.php?flashcard_id=$rekord[id]>edytuj</a>"; //tu przesyłamy id fiszki
        echo "<td><form method=post action=edytuj_fiszke.php>";
        echo "<input type='hidden' name=flashcard_id value=".$rekord['id'].">";
        echo "<input type=submit value='Edit'>";
        echo "</form>";
        echo "<td><a href=usun_fiszke.php?flashcard_id=$rekord[id]>";
        echo"<img alt=\"delete\" src=\"delete-button.png\">";
        echo"</a>";
    }
    echo "</table>";
}

/////////////////////////////3. dodajemy fiszki ///////////////////////////////////////////////////
if(isset($_POST["frm_flash_term"]) && isset($_POST["frm_flash_def"])) //jelsi dodaj_fiszki_do_kategorii.php nie byl uruchomiony po raz pierwszy
    {
        $sql = "insert into flashcards (term, definition,category_id) values (?,?,?)";
        $prep = $conn -> prepare($sql);
        $prep -> bind_param('ssi',$_POST['frm_flash_term'], $_POST['frm_flash_def'], $_SESSION["category_last_id"]); 
        $result = $prep -> execute(); // tu się wykona insert
        if($result){//jeśli się udało
            header("Location: dodaj_fiszki_do_kategorii.php"); //tu załadujemy stronę od nowa, żeby wyświetlić dodaną fiszkę
        }
        else{
            echo "błąd dodania fiszki";
        }
    }

    //////////////////////4. mozliwosc usuniecia calego folderu z fiszkami /////////////////

    echo "<form method=post action=usun_kategorie.php>";
    echo "<input type=submit value='Usuń ten folder'>";
    echo "</form>";



?>