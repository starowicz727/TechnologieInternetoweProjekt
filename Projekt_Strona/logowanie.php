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
		</nav>	
	</header>
    <!-- <fieldset> -->
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
                                    <!-- <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
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
    <!-- </fieldset> -->

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
        echo "<h1 class=\"text-center text-danger\">Invalid username or password</h1>";
        //$_POST["frm_login"];
        ?><body style="background:#632525;"><?php
        //.bg-danger 

        //echo"<center color='blue'>Try again</center>"; //tu wracamy do ponownego logowania, bo nie udało się zalogować
        // echo "bgcolor='blue'>".$rekord["term"];
    }
}

?>
	<!-- Option 1: Bootstrap Bundle with Popper-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	
	<!-- gdyby to powyzej nie dzialalo -->
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->

	<script src="js/bootstrap.min.js"></script>

</body>
</html>

