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
    <div class="language_container">
        <form action="language.php" method="post">
            <input type="hidden" name="lang" value="en">
            <button class="lang_button" type="submit">EN</button>
        </form>
        <form action="language.php" method="post">
            <input type="hidden" name="lang" value="ro">
            <button class="lang_button" type="submit">RO</button>
        </form>
        <form action="language.php" method="post">
            <input type="hidden" name="lang" value="de">
            <button class="lang_button" type="submit">DE</button>
        </form>
    </div>
    <h1>Shop1 - simple PHP</h1>
    <p><?php echo translate("Home page"); ?> - product display</p>
    <?php if($_SESSION["admin"] == true) { ?>
    <a href="admin.php">Manage your products</a>
    <?php } ?>
    <?php if(count($products) != 0) { ?>
    <table class="product_table" style="width:100%">
        <tr>
            <th><?php echo translate("Image"); ?></th>
            <th><?php echo translate("Product name"); ?></th> 
            <th><?php echo translate("Price"); ?></th>
            <th><?php echo translate("Description"); ?></th>
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
                    <button class="add_to_cart_btn" type="submit"><?php echo translate("Add to cart"); ?></button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php } else { ?>
    <h2><?php echo translate("All the products are already in the cart!"); ?> :)</h2>
    <a href="/cart.php"><?php echo translate("See cart"); ?></a>
    <?php } ?>

</body>
</html>