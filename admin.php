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
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
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

        <table class="table">
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
            $sql = "SELECT product_id, name, description, quantity, price FROM products";
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
                                <form style=\"margin-right: 10px;\" action='editProduct.php' method='post'>
                                    <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                                    <button type='submit' class='btn btn-primary btn-sm'>Edit</button>
                                </form>
                            
                                <form action='./Forms/deleteProducts.php' method='post'>
                                    <input type='hidden' name='product_id' value='" . $row["product_id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>
                            </div>
                            
                                

                                    </td>
                              </tr>";
              }
            } else {
              echo "<tr><td colspan='5'>No products found</td></tr>";
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

  <!-- Modal for Editing Item -->
  <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="editItemForm">
            <input type="hidden" id="editItemId" />
            <div class="form-group">
              <label for="editItemName">Item Name:</label>
              <input type="text" class="form-control" id="editItemName" required />
            </div>
            <div class="form-group">
              <label for="editItemQuantity">Item Quantity:</label>
              <input type="number" class="form-control" id="editItemQuantity" required />
            </div>
            <button type="submit" class="btn btn-primary">
              Save Changes
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



  <script></script>
</body>

</html>