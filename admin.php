
<!DOCTYPE html>
<html>
	<head>
		<title>Shop1 - ADMIN</title>
	</head>
<?php
require('config.php');

session_start();
if($_SESSION["admin"] != True) {
	if(!empty($_POST["user"]) && !empty($_POST["password"])) {
		echo "post not empty!";
		if($_POST["user"] == ADMIN_NAME && $_POST["password"] == ADMIN_PASS) {
			$_SESSION["admin"] = True;
		} else {
			header("Location: /login.php?fail=true");
		}
	} else {
		echo "post empty!";
		header("Location: /login.php?fail=true");
	}
}
if($_SESSION["admin"] == True) {
	$sql = 'SELECT id, name, price, description FROM products ORDER BY id';
	$products = array();
	//var_dump($products);
	foreach ($conn->query($sql) as $row) {
		//var_dump($product);
		$products[$row['id']]['id'] = $row['id'];
		$products[$row['id']]['name'] = $row['name'];
		$products[$row['id']]['price'] = $row['price'];
		$products[$row['id']]['description'] = $row['description'];
	}
	//var_dump($_SESSION["admin"]);
?>
	<body>
	<h1>Shop1 - ADMIN for your products</h1>
	<p>Modify, delete or add products</p>
	<a href="/logout.php">Logout</a>
	<table class="product_table" style="width:100%">
	  <tr>
	    <th>Image</th>
	    <th>Product name</th> 
	    <th>Price</th>
	    <th>Description</th>
	    <th>Edit</th>
	    <th>Delete</th>
	  </tr>
	  <?php

		foreach ($products as $product) {
			?>
			<tr>
				<td><img src="/products/<?php echo $product['id'] ?>.png"></td>
				<td><?php echo $product['name'] ?></td>
				<td><?php echo $product['price'] ?></td>
				<td><?php echo $product['description'] ?></td>
				<td>
					<form action="product.php" method="post">
						<input type="hidden" name="action" value="edit">
						<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
						<button class="add_to_cart_btn" type="submit">Edit product</button>
					</form>
				</td>
				<td>
					<form action="product.php" method="post">
						<input type="hidden" name="action" value="delete">
						<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
						<button class="add_to_cart_btn" type="submit">Delete product</button>
					</form>
				</td>
			</tr>
	  <?php
		}
	  ?>
	  
	</table>
	<form action="product.php" method="post">
		<input type="hidden" name="action" value="add_new">
		<input type="hidden" name="id">
		<button class="add_to_cart_btn" type="submit">Add new product</button>
	</form>
	</body>

<?php
} else {
	header("Location: /login.php?fail=true");
}
?>

<style type="text/css">
body {
	margin-left: auto;
	margin-right: auto;
	max-width: 1200px;
}
.product_table th {
	background-color: #222;
	color: #FFF;
	font-weight: bold;
	text-align: left;
	padding: 5px;
}
.product_table img {
	max-width: 200px;
}
.add_to_cart_btn {
    color: #FFF;
    background-color: #0099FF;
    padding: 10px;
    border-radius: 10px;
    text-decoration: none;
}
</style>

</html>