<?php
include '../connector.php';

$connector = new connector();
$id = $_POST['product_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];


$sql = "CALL updateProducts('$id', '$name', '$description', $quantity, $price);";


mysqli_query($connector->conn, $sql);
$connector->conn->close();
// Redirect back to the HTML page with a success message
echo "<script>alert('Item updated successfully');</script>";
echo "<script>window.location.href='../admin.php';</script>";
