<?php
if(isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //jeślii logowanie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // łączymy się z bazą danych

    $sql = "select * from users where login=? and password=?";
    $prep = $conn -> prepare($sql);
    $hash_pass = sha1($_POST['frm_pass']);
    $prep -> bind_param('ss',$_POST['frm_login'], $hash_pass); 
    $prep -> execute(); // tu się wykona select
    $result = $prep -> get_result();

    if($row = $result -> fetch_assoc() != null){ // jeśli select nie zwrócił null => takie konto istnieje=> logowanie powinno się udać
        session_start();
        $_SESSION["login"]= $_POST["frm_login"];
        header("Location: logowanie_ok.php"); //tu przechodzimy do kolejnego skryptu
    }
    else{
        //echo "";
        //$_POST["frm_login"] = "hfbsbf";
        echo "<br><h1 class=\"text-center text-danger\">Invalid username or password</h1>";        
    }
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
	<link rel="stylesheet" href="login.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <style>
        /* Modify the background color */
        /* prosze dzialaj */
         
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
        
        <!-- <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainmenu" aria-controls="mainmenu" aria-expanded="false" aria-label="Przełącznik nawigacji">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="mainmenu">
        
            <ul class="navbar-nav"> -->
            
                <!-- <li class="nav-item">
                    <a style="color: #ffffff" class="nav-link" href="#"> Home </a>
                </li> -->

                <!-- <li class="nav-item">
                    <a style="color: #ffffff" class="nav-link" href="profile.php"> Profile </a>
                </li> -->
<!-- 
                <li class="nav-item">
                    <a style="color: #ffffff" class="nav-link" href="logOut.php"> Log out </a>
                </li> -->
                
                
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
<div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>
        <!-- <form id="login-form" class="form" action="logowanie.php" method="post">
                                <h3 class="text-center text-info">Login</h3>
                                <div class="form-group">
                                    <label for="username" class="text-info">Username:</label><br>
                                    <input type="text" name="frm_login" id="username" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="frm_pass" id="password" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    to zakomentowac
                                     <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                                </div>
                                <div id="register-link" class="text-right">
                                    <a href="rejestracja.php" class="text-info">Don't have an account? <b>Register here</b></a>
                                </div>
                            </form> -->
		
		<form id="login-form" class="form" action="logowanie.php" method="post">        
			<input type="text" name="frm_login" id="username" required="required" placeholder="Username">
			<input type="password" name="frm_pass" id="password" required="required" placeholder="Password">
			<button type="submit" name="submit" id="login-button">Login</button>
            <br>
            <br>
            <div id="register-link" >
            <a href="rejestracja.php">Don't have an account? <b>Register here</b></a>
            </div>
		</form>
	</div>
	
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<!-- <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<!-- <script> $("#login-button").click(function(event){
		 event.preventDefault();
	 
	 $('form').fadeOut(500);
	 $('.wrapper').addClass('form-success');
});
//# sourceURL=pen.js
</script> -->
<!-- </body> -->


<!-- <body>
	<header>	
		<nav class="navbar navbar-dark bg-secondary navbar-expand-md">		
			<a class="navbar-brand" href="#"><img src="img/logo.png" width="30" height="30" class="d-inline-block mr-1 align-bottom" alt=""> Fiszki.pl</a>
		</nav>	
	</header>
    
        <div id="login">
            <h3 class="text-center text-white pt-5"></h3>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="logowanie.php" method="post">
                                <h3 class="text-center text-info">Login</h3>
                                <div class="form-group">
                                    <label for="username" class="text-info">Username:</label><br>
                                    <input type="text" name="frm_login" id="username" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Password:</label><br>
                                    <input type="password" name="frm_pass" id="password" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    to zakomentowac
                                     <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Login">
                                </div>
                                <div id="register-link" class="text-right">
                                    <a href="rejestracja.php" class="text-info">Don't have an account? <b>Register here</b></a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset> -->


	<!-- Option 1: Bootstrap Bundle with Popper-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<!-- gdyby to powyzej nie dzialalo -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->

	<script src="js/bootstrap.min.js"></script>

</body>
</html>

