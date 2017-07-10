<!DOCTYPE html>
<html>
<head>
<title>Shop1 - Home</title>
</head>
<?php
include_once('config.php');

$sql = 'SELECT id, name, price, description FROM products ORDER BY id';
$products = array();;
//var_dump($products);
foreach ($conn->query($sql) as $row) {
	//var_dump($product);
	$products[$row['id']]['id'] = $row['id'];
	$products[$row['id']]['name'] = $row['name'];
	$products[$row['id']]['price'] = $row['price'];
	$products[$row['id']]['description'] = $row['description'];

}

?>

<body>

<h1>Shop1 - simple PHP</h1>
<p>Home page - product display</p>

<table class="product_table" style="width:100%">
  <tr>
    <th>Image</th>
    <th>Product name</th> 
    <th>Price</th>
    <th>Description</th>
    <th></th>
  </tr>
  <?php

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
					<input type="hidden" name="action" value="add">
					<input type="hidden" name="id" value="<?php echo $product['id'] ?>">
					<button class="add_to_cart_btn" type="submit">Add to cart</button>
				</form>
			</td>
		</tr>
  <?php
	}
  ?>
  
</table>

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

<script type="text/javascript">
//alert("alert!");
function sendIdToCart(id) {
	alert(id);
}
</script>

</html>