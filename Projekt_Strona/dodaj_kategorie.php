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

if(isset($_POST["frm_name_categ"])) //jelsi dodaj_kategorie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych
    $users_login = $_SESSION["login"];
    
    $sql = "insert into categories (name, user_login) values (?,?)";
    $prep = $conn -> prepare($sql);
    $prep -> bind_param('ss',$_POST['frm_name_categ'], $users_login); 
    $result = $prep -> execute(); // tu się wykona insert

    if($result){//jeśli się udało
		$last_id = $conn->insert_id; // metoda zwraca ID ostatnio dodanego rekordu
        $_SESSION["category_last_id"] = $last_id;		// zapisujemy w sesji ID kategorii którą przed chwilą dodaliśmy
        header("Location: dodaj_fiszki_do_utworzonej_kategorii.php"); //tu przechodzimy do kolejnego skryptu
    }else{
        show_categ_form();
    }
}
else{
   show_categ_form();
}

function show_categ_form(){
    echo "<form method=post action=dodaj_kategorie.php>";
    echo "<input name=frm_name_categ required=\"required\">Nazwa folderu</br>"; 
    echo "<input type=submit value=Stwórz>";
    echo "</form>";
}

?>