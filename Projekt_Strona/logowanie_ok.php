<?php

session_start();
$_SESSION["category_last_id"]=-1; //na początku nie wybralismy zadnego folderu 

if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}
?>

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
	<link rel="stylesheet" href="logowanie_ok_style.css">
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

		.navbar-custom .navbar-nav > .active > a,
		.navbar-custom .navbar-nav > .active > a:hover,
		.navbar-custom .navbar-nav > .active > a:focus {
    	color: #f04c8c; /*dla testu*/
		
    	background-color: #5d4cfc;
		}

        /* Set the border color */
        .custom-toggler.navbar-toggler {
            border-color: color: #ffffff;
        }

        /* Setting the stroke to green using rgb values (0, 128, 0) */        
        .custom-toggler .navbar-toggler-icon {
            background-image: url(
                "data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
        }
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
            
                <li class="nav-item active">
                    <a style="color: #ffffff" class="nav-link" href="#"> Home </a>
                </li>

                <li class="nav-item disable">
                    <a style="color: #ffffff" class="nav-link" href="profile.php"> Profile </a>
                </li>

                <li class="nav-item disable">
                    <a style="color: #ffffff" class="nav-link" href="logOut.php"> Log out </a>
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
            
            <!-- </ul> -->
        
            <!-- <form class="form-inline">
            
                <input class="form-control mr-1" type="search" placeholder="Wyszukaj" aria-label="Wyszukaj">
                <button class="btn btn-light" type="submit">Znajdź</button>
            
            </form> -->
        
        <!-- </div> -->
    
    </nav>

</header>
<section>
		<div class='container'>
			<div>
				<!-- jesli użytkownik sie zalogował  -->
				<h1>Hello <?php echo $_SESSION["login"];?></h1>
				<h1>Your flashcards:</h1>
				
				<form method=post action=dodaj_kategorie.php>
				<?php show_folders(); ?><br>
				<input type=submit value='Create a new folder'>
				</form>	

		<!-- <form id="register-form" class="form" action="rejestracja.php" method="post">        
			<input type="text" name="re_login" id="username" required="required" placeholder="Username">
			<input type="password" name="re_pass" id="password" required="required" placeholder="Password">
			<button type="submit" name="register" id="register-button">Register</button>
            <br>
            <br>
            <div id="register-link" >
            <a href="logowanie.php">Back to the login page</a>
            </div>
		</form> -->
	

			</div>
		</div>
</section>




	<!-- Option 1: Bootstrap Bundle with Popper-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<!-- gdyby to powyzej nie dzialalo -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->

	<script src="js/bootstrap.min.js"></script>

</body>
</html>

<?php

// //jesli użytkownik sie zalogował 
// echo "Cześć ".$_SESSION["login"];
// echo "Twoje fiszki:";
// show_folders();

// echo "<form method=post action=dodaj_kategorie.php>";
// echo "<input type=submit value='Stwórz nowy folder'>";
// echo "</form>";

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
    
    //if(($rekord = $wynik -> fetch_assoc()) != null){ // gdy mamy już dodany jakiś folder
        echo"<table>";
        while(($rekord = $wynik -> fetch_assoc()) != null) 
        {
			
			// echo "<tr><td>".$rekord["name"];
            // echo "<tr><td><input type=label value=".$rekord['name'].">";

			echo "<tr><td><label>".$rekord['name']."</label".">";
			echo "<td><label></label>";
			echo "<td><label></label>";
			echo "<td><label></label>";
			echo "<td><label></label>";
			echo "<td><label></label>";
			echo "<td><label></label>";
            //echo "<td><a href=dodaj_fiszki_do_kategorii.php?categ_id=$rekord[id]>edytuj</a>"; 
			echo "<td><form method=post action=dodaj_fiszki_do_kategorii.php>";
        	echo "<input type='hidden' name=categ_id value=".$rekord['id'].">";
        	echo "<input type=submit value='Edit this folder'>";
        	echo "</form>";
			//echo "<td><a href=losuj_fiszki_do_kategorii.php?categ_id=$rekord[id]>ucz się</a>"; //tu przesyłamy id kategorii
			echo "<td><form method=post action=ucz_sie.php>";
        	echo "<input type='hidden' name=categ_id value=".$rekord['id'].">";
        	echo "<input type=submit value='Learn'>";
        	echo "</form>";
			//echo "<td><a href=losuj_fiszki_do_kategorii.php?categ_id=$rekord[id]>test</a>"; //tu przesyłamy id kategorii
			echo "<td><form method=post action=sprawdzian.php>";
        	echo "<input type='hidden' name=categ_id value=".$rekord['id'].">";
        	echo "<input type=submit value='Test'>";
        	echo "</form>";
        }
        echo "</table>";
    //}
    // else{
    //     echo "Nie masz jeszcze żadnych folderów. Utwórz pierwszy folder:";
    // }
}
?>