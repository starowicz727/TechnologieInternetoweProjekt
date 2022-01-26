<?php
session_start();
if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}
if($_SESSION["category_last_id"]==-1){ //gdy weszliśmy na te stronę z poziomu logowanie_ok
    $_SESSION["category_last_id"] = $_POST["categ_id"];
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
	<link rel="stylesheet" href="main.css">
	<link rel ="stylesheet" href="ucz_sie_style.css">
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

	



<?php




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

/////////////////////////////1. wyswietlamy fiszki ///////////////////////////////////////////////////
$sql = "SELECT * FROM flashcards WHERE category_id = ". $_SESSION["category_last_id"];
$wynik = $conn -> query($sql);
if($wynik == false){ 
    echo "bledne polecenie sql".$sql;  
    exit;
}
else{
	// $dom->Load("ucz_sie.php");
	// $div = $dom->getElementById('flashcards')->textContent;	  
	// echo $div;
	
	
	?>
	
	<script type="text/javascript" src="ucz_sie_skrypt.js"></script>
		

	<?php
	echo 	"<section>;
				<div class='container'>;
					<div id='flashcards'>";
	
    while(($rekord = $wynik -> fetch_assoc()) != null) // wyświetlamy istniejące fiszki 
    {
/* 		$html = "<div class='flashcard'> 
				 <h2>".$rekord["term"]."</h2>
				 <h2>".$rekord["definition"]."</h2>
				 </div>";
		$dom->loadHTML($html);
		#$div->appendChild($html);

		echo $dom->saveHTML(); */
	/* echo "		<script type='text/javascript'>
		
		  const flashcard = document.createElement('div');
		  const question = document.createElement('h2');
		  const answer = document.createElement('h2');

		  flashcard.className = 'flashcard';

		  question.setAttribute('style', 'border-top:1px solid red; padding: 15px; margin-top:30px');
		  question.textContent = ".$rekord["term"].";

		  answer.setAttribute('style', 'text-align:center; display:none; color:red');
		  answer.textContent = ".$rekord["definition"].";

		  flashcard.appendChild(question);
		  flashcard.appendChild(answer);

		  flashcard.addEventListener('click', () => {
			if(answer.style.display == 'none')
			  answer.style.display = 'block';
			else
			  answer.style.display = 'none';
		  })

		  document.querySelector('#flashcards').appendChild(flashcard);
		
		</script>"; */
		
		echo "<div class='flashcard'> 
				 <h2>".$rekord["term"]."</h2>
				 <h2>".$rekord["definition"]."</h2>
				 </div>";
			
		
		
    }
		echo "	</div>
				</div>
				</section>";
}

    



?>

</body>
</html>