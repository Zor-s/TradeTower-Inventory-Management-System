<?php
include '../connector.php';

$connector = new connector();
$name = $_POST['name'];
$description = $_POST['description'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];


$sql = "CALL addProducts('$name', '$description', $quantity, $price);";


mysqli_query($connector->conn, $sql);

// Redirect back to the HTML page with a success message
echo "<script>alert('Item added successfully');</script>";
echo "<script>window.location.href='../admin.php';</script>";
