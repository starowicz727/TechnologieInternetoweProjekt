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

</body>
</html>

<?php

session_start();

if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

//jesli użytkownik sie zalogował 
echo "Cześć ".$_SESSION["login"];
echo "Twoje fiszki:";
show_folders();

echo "<form method=post action=dodaj_kategorie.php>";
echo "<input type=submit value='Stwórz nowy folder'>";
echo "</form>";

function show_folders(){ //wyświetla wszystkie foldery fiszek == wszystkie kategorie 
    require_once("connect.php"); // łączymy się z bazą danych

    $users_login = $_SESSION["login"];
    //$sql = "SELECT * FROM categories WHERE categories.user_login = \"$users_login \"";
    $sql = "SELECT * FROM categories WHERE user_login = \"$users_login \"";
    $wynik = $conn -> query($sql);
    if($wynik == false){ 
        echo "bledne polecenie sql".$sql;  
        exit;
    }
    
    if(($rekord = $wynik -> fetch_assoc()) != null){ // gdy mamy już dodany jakiś folder
        echo"<table>";
        while(($rekord = $wynik -> fetch_assoc()) != null) 
        {
            echo "<tr><td>".$rekord["name"];
            echo "<td><a href=dodaj_fiszki_do_kategorii.php?categ_id=$rekord[id]>edytuj</a>"; //tu przesyłamy id kategorii
        }
        echo "</table>";
    }
    else{
        echo "Nie masz jeszcze żadnych folderów. Utwórz pierwszy folder:";
    }
    

}

?>