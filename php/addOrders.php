<?php
include '../connector.php';
session_start();
$connector = new connector();
if (isset($_POST['valuesString']) && isset($_POST['productIDString'])) {
    $values = json_decode($_POST['valuesString']);
    $productID = json_decode($_POST['productIDString']);
}


for ($i = 0; $i < $productID; $i++) {
    # code...
    $sql = "INSERT INTO orders (customer_id, quantity, product_id) VALUES (" . $_SESSION["customer_id"] . "," . $values[$i] . "," . $productID[$i] . ");";
    mysqli_query($connector->conn, $sql);


    $sql = "UPDATE products SET quantity = quantity - " . $values[$i] . " WHERE product_id = " . $productID[$i] . ";";
    mysqli_query($connector->conn, $sql);
}


$connector->conn->close();
