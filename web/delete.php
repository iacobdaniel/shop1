<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if($_SESSION["admin"] != True) {
	header("Location: /login.php");
    exit();
} else {
	$id = (int)$_POST["id"];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
	$_SESSION["cart"] = array_diff($_SESSION["cart"], [$id]);
    header("Location: /admin.php");
    exit();
}