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
		</nav>	
	</header>
    <!-- <fieldset> -->
        <div id="login">
            <h3 class="text-center text-white pt-5"></h3>
            <div class="container">
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-6">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="zmien_haslo.php" method="post">
                                <h3 class="text-center text-info">Reset your password</h3>
                                <div class="form-group">
                                    <label for="password" class="text-info">New password:</label><br>
                                    <input type="password" name="frm_pass1" id="username" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="text-info">Repeat new password:</label><br>
                                    <input type="password" name="frm_pass2" id="password" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <!-- <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
                                    <input type="submit" name="submit" class="btn btn-info btn-md" value="Reset">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php

session_start();

if(!isset($_SESSION["login"])){ //jesli użytkownik sie nie zalogował 
    header("Location: logowanie.php");
    exit;
}

if(isset($_POST["frm_pass1"]) && isset($_POST["frm_pass2"])) //jeślii zmien_haslo.php nie byl uruchomiony po raz pierwszy
{
	if($_POST["frm_pass1"] == $_POST["frm_pass2"]){
		require_once("connect.php"); // łączymy się z bazą danych
	}
	else{
		echo "<h1 class=\"text-center text-danger\">Both passwords must be the same</h1>";
		?><body style="background:#632525;"><?php
	}
}

?>

</body>
</html>