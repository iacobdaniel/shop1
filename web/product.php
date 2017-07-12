<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if($_SESSION["admin"] != True) {
	header("Location: /login.php");
} else {
	$id = $_POST["id"];
    $product = array();
	if($id == "new") {
        $product['id'] = "";
		$product['name'] = "";
		$product['price'] = "";
		$product['description'] = "";
        $edit = false;
	} else {
        $stmt = $conn->prepare("SELECT id, name, price, description FROM products WHERE id = ?");
        $id = (int)$id;
        if($stmt->execute([$id])) {
            $row = $stmt->fetch();
            $product = $row;
        }
        $edit = true;
    }
}


?>
<!DOCTYPE html>
<html>
	<head>
        <?php if($edit == true) { ?>
        <title>Shop1 - Edit product</title>
        <?php } else { ?>
        <title>Shop1 - Add new product</title>
        <?php } ?>
		<link rel="stylesheet" type="text/css" href="/css/custom.css" />
	</head>

	<body>
		<?php if($edit == true) { ?>
        <h1>Shop1 - EDIT <?php echo $product['name'] ?></h1>
		<?php } else { ?>
        <h1>Shop1 - ADD NEW PRODUCT</h1>
		<?php } ?>

		<form action="save.php" method="post">
			<input type="hidden" name="id" value="<?php echo ($edit) ? $product['id'] : "new" ?>">
			<label for="name">Name</label>
			<input type="text" name="name" value="<?php echo $product['name'] ?>">
			<br>
			<br>
			<label for="price">Price</label>
			<input type="text" name="price" value="<?php echo $product['price'] ?>">
			<br>
			<br>
			<label for="description">Description</label>
			<textarea type="text" name="description"><?php echo $product['description'] ?></textarea>
			<br>
			<br>
			<?php if($edit == true) { ?>
			<button class="add_to_cart_btn" type="submit">Save</button>
			<?php } else { ?>
			<button class="add_to_cart_btn" type="submit">Add</button>
			<?php } ?>
		</form>

	</body>
</html>