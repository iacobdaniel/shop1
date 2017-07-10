<?php
require('config.php');
session_start();

if($_SESSION["admin"] != True) {
	header("Location: /login.php");
} else {
	var_dump($_POST['id']);
	var_dump($_POST['name']);
	var_dump($_POST['price']);
	var_dump($_POST['description']);
	$id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$description = $_POST['description'];
	$values = "('".$name."',".$price.",'".$description."')";
	var_dump($values);
	if($_POST['id'] == "") {
		$sql = "INSERT INTO products(name, price, description) VALUES ".$values;
		$conn->query($sql);
		header("Location: /admin.php");
	} else {
		$sql = "UPDATE products SET name = '".$name."', price = ".$price.", description = '".$description."' WHERE id = ".$id;
		$conn->query($sql);
		header("Location: /admin.php");
	}

}