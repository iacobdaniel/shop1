<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if(isset($_POST["id"])) {
    $post_id = (int)$_POST["id"];
    if(isset($_POST["action"])) {
        if($_POST["action"] == "add") {
            if(!in_array($post_id, $_SESSION["cart"])) {
                $_SESSION["cart"][] = $post_id;
            }
        } else if($_POST["action"] == "remove") {
            $_SESSION["cart"] = array_diff($_SESSION["cart"], [$post_id]);
        }
    }
}
$products = [];
if(count($_SESSION["cart"]) != 0) {
    $stmt = $conn->prepare("SELECT id, name, price, description FROM products WHERE id IN(" . implode(',', array_fill(0, count($_SESSION["cart"]), '?')) . ") ORDER BY id");
    $product_names = [];
    if($stmt->execute(array_values($_SESSION["cart"]))) {
        while($row = $stmt->fetch()) {
            $products[$row['id']] = $row;
            $product_names[] = $row["name"];
            $products[$row['id']]['image_file'] = glob("./products/" . (string)$row['id'] . ".*")[0];
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shop1 - Cart</title>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
    </head>
    <body>
        <h1>Shop1 - simple PHP - <?php echo translate("Cart page"); ?></h1>
        <a href="/"><?php echo translate("Go to homepage"); ?></a>
        <?php if(count($products) == 0): ?>
        <h2><?php echo translate("The shopping cart is empty."); ?></h2>
        <?php else: ?>
        <table class="product_table" style="width:100%">
            <tr>
                <th><?php echo translate("Image"); ?></th>
                <th><?php echo translate("Product name"); ?></th> 
                <th><?php echo translate("Price"); ?></th>
                <th><?php echo translate("Description"); ?></th>
                <th></th>
            </tr>
            <?php foreach ($products as $product):	?>
            <tr>
                <td><img src="<?php echo $product['image_file'] ?>"></td>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button class="add_to_cart_btn" type="submit"><?php echo translate("Remove from cart"); ?></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3><?php echo translate("Order the stuff"); ?></h3>
        <form action="email.php" method="post">
            <input type="hidden" name="ordered_products" value="<?php echo implode(", ", $product_names); ?>">
            <input required placeholder="<?php echo translate("Name"); ?>" type="text" name="client">
            <br>
            <br>
            <input required placeholder="<?php echo translate("email"); ?>" type="text" name="email">
            <br>
            <br>
            <textarea placeholder="<?php echo translate("Other details..."); ?>" name="details"></textarea>
            <br>
            <br>
            <button type="submit"><?php echo translate("Order now!"); ?></button>
        </form>
        <?php endif; ?>
    </body>
</html>