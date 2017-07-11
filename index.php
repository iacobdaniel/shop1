<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

$products = array();

if(count($_SESSION["cart"]) != 0) {
    $stmt = $conn->prepare("SELECT id, name, price, description FROM products WHERE id NOT IN(" . implode(',', array_fill(0, count($_SESSION["cart"]), '?')) . ")");
	if($stmt->execute(array_values($_SESSION["cart"]))) {
		while($row = $stmt->fetch()) {
			$products[$row['id']] = $row;
		}
	}
} else {
    $sql = 'SELECT id, name, price, description FROM products ORDER BY id';
    foreach ($conn->query($sql) as $row):
        $products[$row['id']] = $row;
    endforeach;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Shop1 - Home</title>
	<link rel="stylesheet" type="text/css" href="/css/custom.css" />
</head>
<body>

    <h1>Shop1 - simple PHP</h1>
    <p>Home page - product display</p>
    <?php if($_SESSION["admin"] == true) { ?>
    <a href="admin.php">Manage your products</a>
    <?php } ?>
    <?php if(count($products) != 0) { ?>
    <table class="product_table" style="width:100%">
        <tr>
            <th>Image</th>
            <th>Product name</th> 
            <th>Price</th>
            <th>Description</th>
            <th></th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><img src="/products/<?php echo $product['id'] ?>.png"></td>
            <td><?php echo $product['name'] ?></td>
            <td><?php echo $product['price'] ?></td>
            <td><?php echo $product['description'] ?></td>
            <td>
                <form action="cart.php" method="post">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                <button class="add_to_cart_btn" type="submit">Add to cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php } else { ?>
    <h2>All the products are already in the cart! :)</h2>
    <a href="/cart.php">See cart</a>
    <?php } ?>

</body>
</html>