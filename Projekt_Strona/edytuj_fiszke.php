<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Fiszki</title>
	<meta name="description" content="Strona z fiszkami">
	<meta name="keywords" content="fiszki, nauka">
	<meta name="author" content="Grupa1">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>

	<header>
	
		<nav class="navbar navbar-dark bg-secondary navbar-expand-md">
		
			<a class="navbar-brand" href="#"><img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt=""> Fiszki.pl</a> <!--obrazek sie zawsze wyswietla-->
		
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
				<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="mainmenu">
			
				<ul class="navbar-nav mr-auto">
				
					<li class="nav-item disable">
						<a class="nav-link" href="logowanie_ok.php"> Home </a>
					</li>

                    <li class="nav-item disable">
						<a class="nav-link" href="profile.php"> Profile </a>
					</li>

                    <li class="nav-item disable">
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

</body>
</html>


<?php
session_start();
require_once("connect.php"); // łączymy się z bazą danych
$flashcard_id = $_GET["flashcard_id"];
$flashc_term = "";
$flashc_def = "";
$category_id = ""; // potrzebne żeby znowu wrócić do widoku folderu z już wyedytowaną fiszką 
/////////////////////////////1. szukamy informacji jak póki co wygląda fiszka///////////////////////////////////
$sql = "SELECT term,definition,category_id FROM flashcards WHERE id = ". $flashcard_id;
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
	$wynik = $wynik -> fetch_assoc();
    $flashc_term = $wynik["term"];
	$flashc_def = $wynik["definition"];
	$category_id = $wynik["category_id"];
}

echo "<form method=post action=edytuj_fiszke.php>";
echo "<input name=frm_flash_term value=".$flashc_term." required=\"required\">Term</br>"; 
echo "<input name=frm_flash_def value=".$flashc_def." required=\"required\">Definition</br>"; 
echo "<input type=submit value=Edit>";
echo "</form>";

if(isset($_POST["frm_flash_term"]) && isset($_POST["frm_flash_def"])){
	$sql = "update flashcards set term=?, definition=? where id=?";
	$prep = $polaczenie -> prepare($sql);
	$prep -> bind_param('ssi',$_POST['frm_flash_term'],$_POST['frm_flash_def'], $flashcard_id); 
	$prep -> execute(); // tutaj wykona się insert 
	$_SESSION["category_last_id"] = $category_id;
	header("Location: dodaj_fiszki_do_utworzonej_kategorii.php"); //tu wracamy do widoku całego folderu, korzystamy z tego skryptu a nie z dodaj_fiszki_do_kategorii, żeby nie używać get
}

?>