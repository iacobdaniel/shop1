<?php
echo "string";

//var_dump($_POST['ordered_products']);
//var_dump($_POST['client']);
//var_dump($_POST['email']);
//var_dump($_POST['details']);

$products = $_POST['ordered_products'];
$client = $_POST['client'];
$client_email = $_POST['email'];
$details = $_POST['details'];

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

if(!mail($to,$subject,$message,$headers)) {
	header("Location: /mail_fail.php");
} else {
	$_SESSION["cart"] = "";
	header("Location: /mail_success.php");
}
