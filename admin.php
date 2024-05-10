<?php
include "./connector.php";
$connector = new connector();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" /> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <style>
    body {
      background: linear-gradient(135deg, #007bff, #42d0ff);
      background-repeat: no-repeat;
      background-attachment: fixed;
      height: 100%;
    }

    .container {
      background-color: #ffffff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
    }

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
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light transparent-navbar">
    <a class="navbar-brand" href="#">Admin Dashboard</a>
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

  <div class="main">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h2 class="mt-5 mb-4">Inventory Items</h2>
          <div class="container mt-5">
            <h2>Add Product</h2>
            <form method="post" action="./Forms/addProducts.php">
              <div class="mb-3">
                <label for="productName" class="form-label">Name</label>
                <input name="name" type="text" class="form-control" id="productName" maxlength="255" required />
              </div>
              <div class="mb-3">
                <label for="productDescription" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="productDescription" rows="3" required></textarea>
              </div>
              <div class="row g-3 mb-3">
                <div class="col">
                  <label for="productQuantity" class="form-label">Quantity</label>
                  <input name="quantity" type="number" class="form-control" id="productQuantity" required />
                </div>
                <div class="col">
                  <label for="productPrice" class="form-label">Price</label>
                  <input name="price" type="number" class="form-control" id="productPrice" pattern="^\d*(\.\d{0,2})?$" required />
                </div>
              </div>
              <button type="submit" class="btn btn-success">
                Add Product
              </button>
            </form>
          </div>
        </div>
      </div>

      <div class="container mt-5 table-responsive">

        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php


            // SQL query to select all data from the table
            $sql    = "SELECT product_id, name, description, quantity, price FROM products";
            $result = $connector->conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
              // Output data of each row
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                                <th scope=\"row\">" . $row["product_id"] . "</th>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["description"] . "</td>
                                <td>" . $row["quantity"] . "</td>
                                <td>" . $row["price"] . "</td>
                                <td>


                                <div class=\"d-flex justify-content-start\">

                                <button onclick='getValue(".$row["product_id"].")' class='btn btn-primary btn-sm' type=\"button\" data-bs-toggle=\"modal\" data-bs-target=\"#editModal\">
                                   Edit
                                </button>
                                                            
                                <form action='./Forms/deleteProducts.php' method='post'>
                                    <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>
                            </div>
                            
                                

                                    </td>
                              </tr>";
              }
            } else {
              echo "<tr><td class=\"text-center\"colspan='6'>No products found</td></tr>";
            }


            ?>
          </tbody>
        </table>


        <div class="row mt-4 d-flex justify-content-center">
          <div class="col-lg-6">
            <div class="colored-container">
              <h2 class="mt-5 mb-4">Available Stocks</h2>
              <h4>Total: <span id="availableStocks">0</span></h4>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="colored-container">
              <h2 class="mt-5 mb-4">Total Products</h2>
              <h4>Total: <span id="totalProducts">0</span></h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Product Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">



          <form id="updateForm" method="post" action="./Forms/updateProducts.php">
          <input type="hidden" id="hiddenInput" name="product_id" value="">
            <div class="mb-3">
              <label for="productName2" class="form-label">Name</label>
              <input name="name" type="text" class="form-control" id="productName2" maxlength="255" required />
            </div>
            <div class="mb-3">
              <label for="productDescription2" class="form-label">Description</label>
              <textarea name="description" class="form-control" id="productDescription2" rows="3" required></textarea>
            </div>
            <div class="row g-3 mb-3">
              <div class="col">
                <label for="productQuantity2" class="form-label">Quantity</label>
                <input name="quantity" type="number" class="form-control" id="productQuantity2" required />
              </div>
              <div class="col">
                <label for="productPrice2" class="form-label">Price</label>
                <input name="price" type="number" class="form-control" id="productPrice2" pattern="^\d*(\.\d{0,2})?$" required />
              </div>
            </div>
          </form>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button onclick="submitForm()" type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

  <script>

    function getValue(value) {
      document.getElementById('hiddenInput').value = value; // Set the value to the hidden input
    }
    // Vanilla JavaScript equivalent
document.addEventListener('click', function(event) {
  if (event.target.dataset.toggle === 'modal') {
    var value = event.target.dataset.productid; // Get the value from the button
    document.getElementById('hiddenInput').value = value; // Set the value to the hidden input
  }
});



function submitForm() {
    // Get the form element by its ID
    const form = document.getElementById('updateForm'); // Replace 'myForm' with your actual form ID

    // Perform any necessary validation here
    // For example, check if required fields are filled out

    // Submit the form
    form.submit();
}


  </script>
</body>

</html>