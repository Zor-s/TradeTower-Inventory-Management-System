<?php
include '../connector.php';
session_start();
$connector = new connector();
$connector2 = new connector();




if (isset($_POST['valuesString']) && isset($_POST['productIDString'])) {
    $values = json_decode($_POST['valuesString']);
    $productID = json_decode($_POST['productIDString']);
}









for ($i = 0; $i < $productID; $i++) {


    $sql = "SELECT IF(quantity >= " . $values[$i] . ", 1, 0) AS quantity_check FROM products WHERE product_id = " . $productID[$i] . "";
    $result = $connector2->conn->query($sql);

    // Check if the query was successful
    if ($result->num_rows > 0) {
        // Output data of each row
        $row = $result->fetch_assoc();
    } else {
        $row = 0;
    }
    

    # code...


    if ($row["quantity_check"]) {
        # code...
        $sql = "INSERT INTO orders (customer_id, quantity, product_id) VALUES (" . $_SESSION["customer_id"] . "," . $values[$i] . "," . $productID[$i] . ");";
        mysqli_query($connector->conn, $sql);


        $sql = "UPDATE products SET quantity = quantity - " . $values[$i] . " WHERE product_id = " . $productID[$i] . ";";
        mysqli_query($connector->conn, $sql);
    } else {
        # code...
        http_response_code(500);
    }
}


$connector->conn->close();
$connector2->conn->close();
