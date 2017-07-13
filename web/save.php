<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if(!$_SESSION["admin"]) {
    header("Location: /login.php");
    exit();
} else {
    $name = strip_tags($_POST['name']);    
    $price = (int)$_POST['price'];
    $description = strip_tags($_POST['description']);
    $image = true;
    if($_FILES["image_upload"]["error"]) {
        $image = false;
    }
    $target_dir = "products/";
    $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
    $uploadOk = true;
    $imageFileInfo = pathinfo($target_file);
    $imageFileType = $imageFileInfo["extension"];
    $check = getimagesize($_FILES["image_upload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = true;
    } else {
        $uploadOk = false;
    }
    if($imageFileType == "png" || $imageFileType == "jpg") {
        $uploadOk = true;
    } else {
        $uploadOk = false;
    }
    if ($_FILES["image_upload"]["size"] > 250000) {
        $uploadOk = false;
    }
    if($_POST['id'] == "new") {
        if(!$uploadOk) {
            header("Location: /product.php?id=new&name=" . $name . "&price=" . $price . "&desc=" . $description);
            exit();
        }
        $stmt = $conn->prepare("INSERT INTO products(name, price, description) VALUES (?,?,?)");
        $stmt->execute([$name, $price, $description]);
        $stmt = $conn->query("SELECT LAST_INSERT_ID()");
        $id = $stmt->fetchColumn();
    } else {
        $id = (int)$_POST['id'];
        if(!$uploadOk && $image) {
            header("Location: /product.php?id=" . $id . "&name=" . $name . "&price=" . $price . "&desc=" . $description);
            exit();
        }
        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ? WHERE id = ?");
        $stmt->execute([$name, $price, $description, $id]);
    }
    if($image) {
        if (!move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_dir . (string)$id . "." . $imageFileType)) {
            header("Location: /product.php?id=new&name=" . $name . "&price=" . $price . "&desc=" . $description);
            exit();
        }
    }
    header("Location: /admin.php");
    exit();
}
