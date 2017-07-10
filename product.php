<?php
require('config.php');
session_start();

if($_SESSION["admin"] != True) {
	header("Location: /login.php?fail=true");
} else {
	//var_dump($_POST["action"]);
	//var_dump($_POST["id"]);
	$action = clean($_POST["action"]);
	$id = (int)$_POST["id"];
	if($action == "delete") {
		$sql = "DELETE FROM products WHERE id=".$id;
		$conn->query($sql);
		header("Location: /admin.php");
	}
	if($action == "edit") {
		$sql = 'SELECT id, name, price, description FROM products WHERE id='.$id;
		$product = array();
		//var_dump($products);
		foreach ($conn->query($sql) as $row) {
			//var_dump($product);
			$product['id'] = $row['id'];
			$product['name'] = $row['name'];
			$product['price'] = $row['price'];
			$product['description'] = $row['description'];
			$edit = true;
		}
		var_dump($product);
	} 
	if($action == "add_new") {
		$product['id'] = "";
		$product['name'] = "";
		$product['price'] = "";
		$product['description'] = "";
		$edit = false;
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Shop1 - Login</title>
	</head>

	<body>
		<?php if($edit == true) { ?>
			<h1>Shop1 - EDIT <?php echo $product['name'] ?></h1>
		<?php } else { ?>
			<h1>Shop1 - ADD NEW PRODUCT</h1>
		<?php } ?>

		<form action="product_modify.php" method="post">
			<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
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