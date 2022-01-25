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
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
</head>

<body>

	<header>
	
		<nav class="navbar navbar-dark bg-secondary navbar-expand-md">
		
			<a class="navbar-brand" href="#"><img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt=""> Fiszki.pl</a> <!--obrazek sie zawsze wyswietla-->
		
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav">
				
					<li class="nav-item">
						<a class="nav-link" href="#"> Home </a>
					</li>

                    <li class="nav-item">
						<a class="nav-link" href="profile.php"> Profile </a>
					</li>

                    <li class="nav-item">
						<a class="nav-link" href="logOut.php"> Log out </a>
					</li>
					
					
					<!-- <li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false" id="submenu" aria-haspopup="true"> Zawody </a>
						
						<div class="dropdown-menu" aria-labelledby="submenu">
						
							<a class="dropdown-item" href="#"> Terminarz zawodów </a>
							<a class="dropdown-item" href="#"> Ranking Pucharu Świata </a>
							
							<div class="dropdown-divider"></div>
							
							<a class="dropdown-item" href="#"> Sylwetki zawodników </a>
							<a class="dropdown-item" href="#"> Skocznie narciarskie </a>
						
						</div>
						
					</li> -->
					

					<!-- <li class="nav-item">
						<a class="nav-link" href="#"> Zdjęcia </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link disabled" href="#"> Wywiady </a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="#"> Kontakt </a>
					</li> -->
				
				</ul>
			
				<!-- <form class="form-inline">
				
					<input class="form-control mr-1" type="search" placeholder="Wyszukaj" aria-label="Wyszukaj">
					<button class="btn btn-light" type="submit">Znajdź</button>
				
				</form> -->
			
			</div>
		
		</nav>
	
	</header>

	<!-- Option 1: Bootstrap Bundle with Popper-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<!-- gdyby to powyzej nie dzialalo -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->

	<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php
session_start();
if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

if($_SESSION["category_last_id"]==-1){ //gdy weszliśmy na te stronę z poziomu logowanie_ok
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
        echo "<td><a href=usun_fiszke.php?flashcard_delete_id=$rekord[id]>";
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
    echo "<input type='hidden' name=cat_delete value=".$_SESSION["category_last_id"].">";
    echo "<input type=submit value='Usuń ten folder'>";
    echo "</form>";



?>