
<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

if(!$_SESSION["admin"]) {
    header("Location: /login.php");
    exit();
} else {
    $sql = 'SELECT id, name, price, description FROM products ORDER BY id';
    $products = [];
    foreach ($conn->query($sql) as $row) {
        $products[$row['id']] = $row;
        $products[$row['id']]['image_file'] = glob("./products/" . (string)$row['id'] . ".*")[0];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Shop1 - ADMIN</title>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
    </head>
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
            <?php foreach ($products as $product): ?>
            <tr>
                <td><img src="<?php echo $product['image_file'] ?>"></td>
                <td><?php echo $product['name'] ?></td>
                <td><?php echo $product['price'] ?></td>
                <td><?php echo $product['description'] ?></td>
                <td>
                    <form action="product.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button class="add_to_cart_btn" type="submit">Edit product</button>
                    </form>
                </td>
                <td>
                    <form action="delete.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button class="add_to_cart_btn" type="submit">Delete product</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <form action="product.php" method="post">
            <input type="hidden" name="id" value="new">
            <button class="add_to_cart_btn" type="submit">Add new product</button>
        </form>
    </body>
</html>