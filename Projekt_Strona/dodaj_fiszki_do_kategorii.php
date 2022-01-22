<?php
session_start();
$added_category = $_SESSION["category_last_id"];

echo "folder: ".$added_category;
flashcard_form();
show_flashcards();
add_flashcard();

function show_flashcards(){
    require_once("connect.php"); // łączymy się z bazą danych
    $sql = "SELECT * FROM flashcards WHERE category_id = ". $added_category;
    $wynik = $conn -> query($sql);
    if($wynik == false){ 
        echo "bledne polecenie sql".$sql;  
        exit;
    }
    else{
        echo "<table border><th>Term<th>Definition";
        while(($rekord = $wynik -> fetch_assoc()) != null) // wyświetlamy istniejące fiszki 
        {
            echo"<table>";
            echo "<tr><td>".$rekord["term"];
            echo "<tr><td>".$rekord["definition"];
            echo "<td><a href=edytuj_fiszke.php?flashcard_id=$rekord[id]>edytuj</a>"; //tu przesyłamy id fiszki
            echo "<td><a href=usun_fiszke.php?flashcard_id=$rekord[id]>";
            echo"<img alt=\"delete\" src=\"delete-button.png\">";
            echo"</a>";
        }
        echo "</table>";
    }
    
}

function flashcard_form(){
    echo "<form method=post action=dodaj_fiszki_do_kategorii.php>";
    echo "<input name=frm_flash_term required=\"required\">Term</br>"; 
    echo "<input name=frm_flash_def required=\"required\">Definition</br>"; 
    echo "<input type=submit value=Stwórz>";
    echo "</form>";
}

function add_flashcard(){
    if(isset($_POST["frm_flash_term"]) && isset($_POST["frm_flash_def"])) //jelsi dodaj_fiszki_do_kategorii.php nie byl uruchomiony po raz pierwszy
    {
        require_once("connect.php"); // łączymy się z bazą danych

        $sql = "insert into flashcards (term, definition,category_id) values (?,?,?)";
        $prep = $conn -> prepare($sql);
        $prep -> bind_param('ssi',$_POST['frm_flash_term'], $_POST['frm_flash_def'], $added_category); 
        $result = $prep -> execute(); // tu się wykona insert
        if($result){//jeśli się udało
            header("Location: logowanie.php"); //tu załadujemy stronę od nowa, żeby wyświetlić dodaną fiszkę
        }
        else{
            echo "błąd dodania fiszki";
        }
    }
}

?>