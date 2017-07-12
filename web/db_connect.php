<?php
try {
	//$conn = new PDO("mysql:host=$servername;dbname=shop1db", $username, $password);
	$conn = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME, DB_USERNAME, DB_USER_PASS);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connected successfully"; 
	}	
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    die();
    }

?>