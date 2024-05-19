<?php
include "./connector.php";
$connector = new connector();
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Marketplace</title>
  <!-- Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> -->

  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    /* Transparent Navbar */
    .transparent-navbar {
      background-color: transparent !important;
    }

    /* White Text Navbar Links */
    .navbar-light .navbar-nav .nav-link {
      color: white !important;
      font-size: 18px;
      /* Adjust font size as needed */
    }

    /* White Text for Admin Dashboard */
    .navbar-brand {
      color: white !important;
      font-size: 24px;
      /* Adjust font size as needed */
    }

    .product-card {
      margin-bottom: 30px;
    }

    .product-card img {
      max-width: 100%;
      height: auto;
    }

    /* Style for cart section */
    #cart-items {
      margin-top: 50px;
    }

    /* Gradient Background */
    body {
      background: linear-gradient(135deg, #007bff, #42d0ff);
      background-repeat: no-repeat;
      background-attachment: fixed;
      height: 100%;
    }

    /* White box container */
    .content-container {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light transparent-navbar">
    <a class="navbar-brand" href="#">Customer Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Features</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="content-container">
          <div class="row">
            <!-- Product Card 1 -->
            <!-- <div class="col-lg-4 col-md-6">
              <div class="card product-card">

                <div class="card-body">
                  <h5 class="card-title">Product 1</h5>
                  <p class="card-text">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                  </p>
                  <div class="d-flex">
                    <p>Price: <b>$20</b></p>
                    <p class="mx-3">Stock: <b>10</b></p>
                  </div>

                  <div class="col-6">
                    <div class="input-group">
                      <button class="btn btn-outline-secondary" type="button" id="decrement-btn">-</button>
                      <input type="text" class="form-control" value="0" id="counter-input">
                      <button class="btn btn-outline-secondary" type="button" id="increment-btn">+</button>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->





            <?php
            // SQL query to select all products
            $sql = "SELECT product_id, name, description, quantity, price FROM products";
            $result = $connector->conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {

                echo "
                <div class=\"col-lg-4 col-md-6\">
                <div class=\"card product-card\">
  
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">" . $row["name"] . "</h5>
                    <p class=\"card-text\">
                      " . $row["description"] . "
                    </p>
                    <div class=\"d-flex\">
                      <p>Price: <b>$" . $row["price"] . "</b></p>
                      <p class=\"mx-3\">Stock: <b>" . $row["quantity"]  . "</b></p>
                    </div>
  
                    <div class=\"col-6\">
                      <div class=\"input-group\">
                        <button class=\"btn btn-outline-secondary \" type=\"button\" id=\"decrement-btn" . $row["product_id"] . "\">-</button>
                        <input value='0' min='0' max='" . $row["quantity"] . "' type=\"text\" class=\"form-control inputGroup\" value=\"0\" id=\"" . $row["product_id"] . "\">
                        <button class=\"btn btn-outline-secondary\" type=\"button\" id=\"increment-btn" . $row["product_id"] . "\">+</button>
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>



              <script>
              document.getElementById('increment-btn" . $row["product_id"] . "').addEventListener('click', function() {
                document.getElementById('" . $row["product_id"] . "').value = parseInt(document.getElementById('" . $row["product_id"] . "').value) + 1;
              });
          
              document.getElementById('decrement-btn" . $row["product_id"] . "').addEventListener('click', function() {
                document.getElementById('" . $row["product_id"] . "').value = parseInt(document.getElementById('" . $row["product_id"] . "').value) - 1;
              });
            </script>
                
                ";
              }
            } else {
              echo "0 results";
            }

            // Close connection 
            $connector->conn->close();
            ?>







          </div>
          <button onclick="placeOrder()" class="btn btn-primary add-to-cart" data-product="Product 1" data-price="20">
            Place Order
          </button>

          <!-- Cart Section -->
          <div class="container" id="cart-items">
            <h2>Cart</h2>
            <ul class="list-group" id="cart-list">
              <!-- Cart items will be dynamically added here -->
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and jQuery -->
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <!-- <script>
    $(document).ready(function() {
      // Add to Cart Button Click Event
      $(".add-to-cart").click(function() {
        // Get product name and price from data attributes
        var productName = $(this).data("product");
        var productPrice = $(this).data("price");

        // Create new cart item
        var cartItem = {
          name: productName,
          price: productPrice,
        };

        // Get existing cart items from localStorage or create an empty array
        var cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Add new item to cart
        cart.push(cartItem);

        // Keep only the last three items in the cart
        if (cart.length > 3) {
          cart = cart.slice(cart.length - 3);
        }

        // Update cart in localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        // Update cart display
        updateCartDisplay();

        // Alert user that the product has been added to cart (you can replace this with a more sophisticated notification)
        alert("Product added to cart!");
      });

      // Delete Item Button Click Event
      $(document).on("click", ".delete-item", function() {
        // Get the index of the item to be deleted
        var index = $(this).data("index");

        // Retrieve cart items from localStorage
        var cart = JSON.parse(localStorage.getItem("cart")) || [];

        // Remove the item from the cart array
        cart.splice(index, 1);

        // Update cart in localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        // Update cart display
        updateCartDisplay();
      });

      // Function to update cart display
      function updateCartDisplay() {
        var cartItems = JSON.parse(localStorage.getItem("cart")) || [];
        var cartList = $("#cart-list");
        cartList.empty();

        // Add cart items to the list
        cartItems.forEach(function(item, index) {
          var listItem = $(
            '<li class="list-group-item">' +
            item.name +
            " - $" +
            item.price +
            ' <button class="btn btn-danger btn-sm delete-item" data-index="' +
            index +
            '">Delete</button></li>'
          );
          cartList.append(listItem);
        });
      }

      // Call updateCartDisplay when the page loads
      updateCartDisplay();
    });
  </script> -->
  <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


  <script>
    function placeOrder() {
      // Get all input elements with class 'inputGroup'
      var inputs = document.querySelectorAll('.inputGroup');

      // Initialize an array to hold the values
      var values = [];
      var productID = [];

      // Loop through the inputs and push their values into the array
      inputs.forEach(function(input) {
        if (input.value > 0) {
          values.push(input.value);
          productID.push(input.id);

        }
      });
      var valuesString = JSON.stringify(values);
      var productIDString = JSON.stringify(productID);

      $.ajax({
        url: './php/addOrders.php',
        type: 'post',
        data: {
          valuesString: valuesString,
          productIDString: productIDString,
        },
        success: function(response) {
          // console.log(response);
          alert('purchase successful');
          window.location.href = './customer.php';
        },
        error: function(xhr, status, error) {
          // Handle error
          console.log('Error:', xhr.responseText);
        }

      });


      // Print the values
      // console.log(productID + values);
    }
  </script>
</body>

</html>