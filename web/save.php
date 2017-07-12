<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if($_SESSION["admin"] != true) {
	header("Location: /login.php");
} else {
	$name = $_POST['name'];    
	$price = (int)$_POST['price'];
	$description = $_POST['description'];
	
	if($_POST['id'] == "new") {
		$stmt = $conn->prepare("INSERT INTO products(name, price, description) VALUES (?,?,?)");
        $stmt->execute(array($name, $price, $description));
		header("Location: /admin.php");
        exit();
	} else {
        $id = (int)$_POST['id'];
		$stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
		$stmt->execute(array($name, $price, $description, $id));
		header("Location: /admin.php");
        exit();
	}

}
