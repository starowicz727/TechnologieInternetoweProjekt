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
                                    <!-- <label for="remember-me" class="text-info"><span>Remember me</span>??<span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br> -->
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
if(isset($_POST["frm_login"]) && isset($_POST["frm_pass"])) //je??lii logowanie.php nie byl uruchomiony po raz pierwszy
{
    require_once("connect.php"); // ????czymy si?? z baz?? danych

    $sql = "select * from users where login=? and password=?";
    $prep = $conn -> prepare($sql);
    $hash_pass = sha1($_POST['frm_pass']);
    $prep -> bind_param('ss',$_POST['frm_login'], $hash_pass); 
    $prep -> execute(); // tu si?? wykona select
    $result = $prep -> get_result();

    if($row = $result -> fetch_assoc() != null){ // je??li select nie zwr??ci?? null => takie konto istnieje=> logowanie powinno si?? uda??
        session_start();
        $_SESSION["login"]= $_POST["frm_login"];
        header("Location: logowanie_ok.php"); //tu przechodzimy do kolejnego skryptu
    }
    else{
        echo "<h1 class=\"text-center text-danger\">Invalid username or password</h1>";
        //$_POST["frm_login"];
        ?><body style="background:#632525;"><?php
        //.bg-danger 

        //echo"<center color='blue'>Try again</center>"; //tu wracamy do ponownego logowania, bo nie uda??o si?? zalogowa??
        // echo "bgcolor='blue'>".$rekord["term"];
    }
}

?>

</body>
</html>

