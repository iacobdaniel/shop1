<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if($_SESSION["admin"] != true) {
	if(!empty($_POST["user"]) && !empty($_POST["password"])) {
		if($_POST["user"] == ADMIN_NAME && $_POST["password"] == ADMIN_PASS) {
			$_SESSION["admin"] = true;
		}
	} 
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shop1 - Login</title>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
	</head>
	<body>
        <?php if($_SESSION["admin"] == true) { ?>
        <h1>Shop1 - Logged in as ADMIN</h1>
        <h2>What to do next?</h2>
        <p>1. <a href="/admin.php">Manage your products</a></p>
        <p>2. <a href="/">Go to frontend page</a></p>
        <p>3. <a href="/logout.php">Logout</a></p>
        <?php } else { ?>
        <h1>Shop1 - Login</h1>
        <form action="login.php" method="post">
            <label for="user">Username: </label>
            <input type="text" name="user">
            <br>
            <br>
            <label for="password">Password: </label>
            <input type="password" name="password">
            <br>
            <br>
            <button type="submit">Login</button>
        </form>
        <?php } ?>
	</body>

</html>