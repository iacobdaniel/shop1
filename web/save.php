<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if($_SESSION["admin"] != true) {
	header("Location: /login.php");
    exit();
} else {
	$name = strip_tags($_POST['name']);    
	$price = (int)$_POST['price'];
	$description = strip_tags($_POST['description']);
    
    $no_image = false;
    if($_FILES["image_upload"]["error"]) {
        $no_image = true;
    }
    
    $target_dir = "products/";
    $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
    $uploadOk = 1;
    $imageFileInfo = pathinfo($target_file);
    $imageFileType = $imageFileInfo["extension"];
    $check = getimagesize($_FILES["image_upload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if($imageFileType == "png") {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    
    if($_POST['id'] == "new") {
		$stmt = $conn->prepare("INSERT INTO products(name, price, description) VALUES (?,?,?)");
        $stmt->execute([$name, $price, $description]);
        
        $stmt = $conn->query("SELECT LAST_INSERT_ID()");
        $lastId = $stmt->fetchColumn();
        
        if(!$_FILES["image_upload"]["error"]) {
            if ($uploadOk == 1) {
                if (!move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_dir . $lastId . ".png")) {
                    header("Location: /admin.php?file_error=1");
                    exit();
                } 
            } else {
                header("Location: /admin.php?file_error=1");
                exit();
            }
        } else {
            header("Location: /admin.php?file_error=2");
            exit();
        }
        
		header("Location: /admin.php");
        exit();
	} else {
        $id = (int)$_POST['id'];
                    
		$stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
		$stmt->execute([$name, $price, $description, $id]);
        if(!$_FILES["image_upload"]["error"]) {
            if ($uploadOk == 1) {
                if (!move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_dir . (string)$id . ".png")) {
                    header("Location: /admin.php?file_error=1");
                    exit();
                } 
            } else {
                header("Location: /admin.php?file_error=1");
                exit();
            }
        } 
		header("Location: /admin.php");
        exit();
	}
}
