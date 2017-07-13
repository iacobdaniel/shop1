<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if(!$_SESSION["admin"]) {
    header("Location: /login.php");
    exit();
} else {
    $img_error = false;
    if(isset($_REQUEST["name"]) && isset($_REQUEST["price"]) && isset($_REQUEST["desc"])) {
        if(isset($_REQUEST["id"])) {
            if($_REQUEST["id"] == "new" || !is_numeric($_REQUEST["id"])) {
                $product['id'] = "";
            } else {
                $product['id'] = (int)$_REQUEST["id"];
            }
        }
        $product['name'] = strip_tags($_REQUEST["name"]);
        $product['price'] = (int)$_REQUEST["price"];
        $product['description'] = strip_tags($_REQUEST["desc"]);
        $img_error = true;
    } else {
        $id = strip_tags($_POST["id"]);
        $product = [];
        if($id == "new") {
            $product['id'] = "";
            $product['name'] = "";
            $product['price'] = "";
            $product['description'] = "";
        } else {
            $stmt = $conn->prepare("SELECT id, name, price, description FROM products WHERE id = ?");
            $id = (int)$id;
            if($stmt->execute([$id])) {
                $row = $stmt->fetch();
                $product = $row;
            }
            $img_file = glob("./products/" . (string)$id . ".*")[0];
        }
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php if($product['id'] != ""): ?>
        <title>Shop1 - Edit product</title>
        <?php else: ?>
        <title>Shop1 - Add new product</title>
        <?php endif; ?>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
    </head>
    <body>
        <?php if($product['id'] != ""): ?>
        <h1>Shop1 - EDIT <?php echo $product['name'] ?></h1>
        <?php else: ?>
        <h1>Shop1 - ADD NEW PRODUCT</h1>
        <?php endif; ?>
        <?php if($img_error): ?>
        <p class="file_upload_error_notif">Sorry, there was an error uploading your file.</p>
        <?php endif; ?>
        <form action="save.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo ($product['id'] != "") ? $product['id'] : "new" ?>">
            <label for="name">Name</label>
            <br>
            <input type="text" name="name" value="<?php echo $product['name'] ?>">
            <br>
            <br>
            <label for="price">Price</label>
            <br>
            <input type="text" name="price" value="<?php echo $product['price'] ?>">
            <br>
            <br>
            <label for="description">Description</label>
            <br>
            <textarea type="text" name="description"><?php echo $product['description'] ?></textarea>
            <br>
            <br>
            <?php if(($product['id'] != "")): ?>
            <img class="edit_image" src="<?php echo $img_file; ?>">
            <?php endif; ?>
            <label for="image">Upload image (only PNG or JPEG/JPG file types with a maximum dimension of 250kB)</label>
            <br>
            <input type="file" name="image_upload" id="image_upload">
            <br>
            <br>
            <?php if($product['id'] != ""): ?>
            <button class="add_to_cart_btn" type="submit">Save</button>
            <?php else: ?>
            <button class="add_to_cart_btn" type="submit">Add</button>
            <?php endif; ?>
        </form>
    </body>
</html>