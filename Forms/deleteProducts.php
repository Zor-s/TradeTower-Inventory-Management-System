<?php
include '../connector.php';

$connector = new connector();
$product_id = $_POST['product_id'];



$sql = "CALL removeProducts('$product_id');";


mysqli_query($connector->conn, $sql);
$connector->conn->close();

// Redirect back to the HTML page with a success message
echo "<script>alert('Item deleted successfully');</script>";
echo "<script>window.location.href='../admin.php';</script>";
