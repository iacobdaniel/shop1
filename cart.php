<!DOCTYPE html>
<html>
<head>
<title>Shop1 - Cart</title>
</head>

<?php
require('config.php');

session_start();
//var_dump($_SESSION);
//var_dump($_POST);
if (!empty($_POST)) {
	if($_POST["action"] == "add") {
		if($_SESSION["cart"] == "") {
			$_SESSION["cart"] = $_POST["id"];
		} else {
			$prod_ids = explode(',', $_SESSION["cart"]);
			if(!in_array($_POST["id"], $prod_ids)) {
				$_SESSION["cart"] .= ",".$_POST["id"];
			}
		}
	} else if($_POST["action"] == "remove") {
		$prod_ids = explode(',', $_SESSION["cart"]);
		$prod_ids = array_diff($prod_ids, [$_POST["id"]]);
		$_SESSION["cart"] = "";
		$i = 0;
		foreach ($prod_ids as $prod_id) {
			if($i == 0) {
				$_SESSION["cart"] .= $prod_id;
			} else {
				$_SESSION["cart"] .= ','.$prod_id;
			}
			$i++;
		}
	}
}

//$prod_ids = explode(',', $_SESSION["cart"]);
//var_dump($prod_ids);
if($_SESSION["cart"] != "") {
	$sql = "SELECT id, name, price, description FROM products WHERE id IN(".$_SESSION["cart"].") ORDER BY id";

	//$sql = 'SELECT id, name, price, description FROM products ORDER BY id';
	$products = array();
	//var_dump($products);
	foreach ($conn->query($sql) as $row) {
		//var_dump($product);
		$products[$row['id']]['id'] = $row['id'];
		$products[$row['id']]['name'] = $row['name'];
		$products[$row['id']]['price'] = $row['price'];
		$products[$row['id']]['description'] = $row['description'];

	}
} else {
	$products = array();
}

//var_dump($products);

?>
<body>

<h1>Shop1 - simple PHP - Cart page</h1>
<a href="/">Go to homepage</a>
<?php
if(empty($products)) {
?>
<h2>The shopping cart is empty! :( </h2>

<?php
} else {
?>
<table class="product_table" style="width:100%">
  <tr>
    <th>Image</th>
    <th>Product name</th> 
    <th>Price</th>
    <th>Description</th>
    <th></th>
  </tr>
  <?php
  	$product_names = "";
	foreach ($products as $product) {
		?>
		<tr>
			<td><img src="/products/<?php echo $product['id'] ?>.png"></td>
			<td><?php echo $product['name'] ?></td>
			<td><?php echo $product['price'] ?></td>
			<td><?php echo $product['description'] ?></td>
			<?php
			/* 
			// for sending with ajax request
			<td><span class="add_to_cart_btn" onclick="sendIdToCart(<?php echo $product['id'] ?>)">Add to cart</span></td>
			*/
			?>
			<td>
				<form action="cart.php" method="post">
					<input type="hidden" name="action" value="remove">
					<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
					<button class="add_to_cart_btn" type="submit">Remove from cart</button>
				</form>
			</td>
		</tr>
  <?php
  	$product_names .= $product['name'] . ", ";
	}
  ?>
  
</table>
<?php
}
$product_names = substr($product_names, 0, -2);
//var_dump($product_names);
?>
<h3>Order the stuff</h3>
<form action="email.php" method="post">
	<input type="hidden" name="ordered_products" value="<?php echo $product_names; ?>">
	<input required placeholder="Name" type="text" name="client">
	<br>
	<br>
	<input required placeholder="email" type="text" name="email">
	<br>
	<br>
	<textarea placeholder="Other details..." name="details"></textarea>
	<br>
	<br>
	<button type="submit">Order now!</button>
</form>

</body>

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