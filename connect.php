<?php
$db_Username="root";
$db_Passsword="";
$db_HostName="localhost";
$db_DatabaseName="zadania_9";

$conn = new mysqli($db_HostName, $db_Username, $db_Passsword, $db_DatabaseName);
 
if($conn->connect_error)
    {
		die("Connection failed: " . $conn->connect_error);

	}
	
	
	
?>