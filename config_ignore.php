<?php

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

define('DB_SERVER',"db_server");
define('DB_USERNAME',"db_username");
define('DB_USER_PASS',"db_user_pass");
define('DB_NAME', "db_name");

define('ADMIN_NAME', "admin_name");
define('ADMIN_PASS', 'admin_pass');
//global $conn;
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
