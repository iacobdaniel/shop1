<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

$products = [];
if(count($_SESSION["cart"]) != 0) {
    $stmt = $conn->prepare("SELECT id, name, price, description FROM products WHERE id NOT IN(" . implode(',', array_fill(0, count($_SESSION["cart"]), '?')) . ") ORDER BY id");
    if($stmt->execute(array_values($_SESSION["cart"]))) {
        while($row = $stmt->fetch()) {
            $products[$row['id']] = $row;
            $products[$row['id']]['image_file'] = glob("./products/" . (string)$row['id'] . ".*")[0];
        }
    }
} else {
    $sql = 'SELECT id, name, price, description FROM products ORDER BY id';
    foreach ($conn->query($sql) as $row) {
        $products[$row['id']] = $row;
        $products[$row['id']]['image_file'] = glob("./products/" . (string)$row['id'] . ".*")[0];
    }
}
if(isset($_GET["lang"])) {
    $_SESSION["lang"] = strip_tags($_GET["lang"]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shop1 - <?php echo translate("Home"); ?></title>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
    </head>
    <body>
        <div class="language_container">
            <a class="lang_button <?php echo $_SESSION["lang"]=="en" ? "selected" : "" ?>" href="/index.php?lang=en">EN</a>
            <a class="lang_button <?php echo $_SESSION["lang"]=="ro" ? "selected" : "" ?>" href="/index.php?lang=ro">RO</a>
            <a class="lang_button <?php echo $_SESSION["lang"]=="de" ? "selected" : "" ?>" href="/index.php?lang=de">DE</a>
        </div>
        <h1>Shop1 - simple PHP</h1>
        <p><?php echo translate("Home page"); ?> - <?php echo translate("product display"); ?></p>
        <?php if($_SESSION["admin"]): ?>
        <a href="/admin.php"><?php echo translate("Manage your products"); ?></a>
        <?php endif; ?>
        <?php if(count($products) != 0): ?>
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
                <td><img src="<?php echo $product['image_file'] ?>"></td>
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
        <a class="go_to_cart" href="/cart.php"><?php echo translate("See cart"); ?></a>
        <?php else: ?>
        <h2><?php echo translate("All the products are already in the cart or no products are available"); ?></h2>
        <?php endif; ?>
    </body>
</html>