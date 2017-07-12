<?php
require_once('common.php');
session_start();

if(isset($_POST["lang"])) {
    $_SESSION["lang"] = $_POST["lang"];
}
header("Location: /");
exit();