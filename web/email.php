<?php
require_once('config.php');
require_once('common.php');
require_once('db_connect.php');
session_start();

$products = strip_tags($_POST['ordered_products']);
$client = strip_tags($_POST['client']);
$details = strip_tags($_POST['details']);
$client_email = strip_tags($_POST['email']);

$to = "admin@shop1.local.com";
$subject = "New Order";


$message = "
<html>
<head>
<title>HTML email</title>
</head>
<body>
<p>Ordered products:</p>
<p>".$products."</p>
<p>Order details:</p>
<p>".$details."</p>
</body>
</html>
";

//for html email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= "From: <".$client_email.">" . "\r\n";

if(!mail($to,$subject,$message,$headers) || !filter_var($client_email, FILTER_VALIDATE_EMAIL)) {
    $success = false;
} else {
    $_SESSION["cart"] = [];
    $success = true;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Shop1 - Cart</title>
        <link rel="stylesheet" type="text/css" href="/css/custom.css" />
    </head>
    <body>
        <h1><?php echo $success ? "Message succesfully sent!" : "Something went wrong. Please try again later." ?></h1> 
        <a href="/">Back to homepage</a>
    </body>
</html>