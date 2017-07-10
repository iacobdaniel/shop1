<?php
require('config.php');
session_start();

if($_SESSION["admin"] != True) {
	header("Location: /login.php");
} else {
	//var_dump($_POST['id']);
	//var_dump($_POST['name']);
	//var_dump($_POST['price']);
	//var_dump($_POST['description']);
	$id = (int)$_POST['id'];
	$name = clean($_POST['name']);
	$price = (int)$_POST['price'];
	$description = clean($_POST['description']);
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