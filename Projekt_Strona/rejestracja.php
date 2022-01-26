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

	<style>
        /* Modify the background color */
         
        .navbar-custom {
            background-color: #4f3cfa; /* zmienia kolor navbara */
        }
        /* Modify brand and text color */
         
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {navbar navbar-custom navbar-expand-md"
            color: #ffffff;
        }

        /* Set the border color */
        /* .custom-toggler.navbar-toggler {
            border-color: color: #ffffff;
        } */
        /* Setting the stroke to green using rgb values (0, 128, 0) */
/*           
        .custom-toggler .navbar-toggler-icon {
            background-image: url(
                "data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
        } */
    </style>
</head>

<body>

	<header>
	
		<nav class="navbar navbar-custom navbar-expand-md">
    
        	<a style="color: #ffffff" class="navbar-brand" href="#"><img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt="">Flashcards.com</a> <!--obrazek sie zawsze wyswietla-->
        
			<button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
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