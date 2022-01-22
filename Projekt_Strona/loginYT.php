<?php
	session_start();
	
	if (!empty($_POST['login']) && !empty($_POST['password']))
	{
		echo "podano dane";
	}
	else
	{
		echo "nie podano danych";
	}















?>