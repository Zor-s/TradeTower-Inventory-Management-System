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
                  <input name="price" type="text" class="form-control" id="productPrice" pattern="^\d*(\.\d{0,2})?$" required />
                </div>
              </div>
              <button type="submit" class="btn btn-primary">
                Add Product
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col-lg-12">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="inventoryTableBody">
              <!-- Inventory items will be dynamically added here -->
            </tbody>
          </table>
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

      <div class="row mt-4">
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

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Sample inventory data
    let inventory = [{
        id: 1,
        name: "Item 1",
        quantity: 10
      },
      {
        id: 2,
        name: "Item 2",
        quantity: 15
      },
      {
        id: 3,
        name: "Item 3",
        quantity: 20
      },
    ];

    // Function to render inventory items
    function renderInventory() {
      const inventoryTableBody =
        document.getElementById("inventoryTableBody");
      inventoryTableBody.innerHTML = "";

      inventory.forEach((item) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-btn" data-id="${item.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${item.id}">Delete</button>
                    </td>
                `;
        inventoryTableBody.appendChild(row);
      });

      updateStocksAndProductCounters();
    }

    // Function to update stocks and product counters
    function updateStocksAndProductCounters() {
      const availableStocks = inventory.reduce(
        (total, item) => total + item.quantity,
        0
      );
      document.getElementById("availableStocks").innerText = availableStocks;

      const totalProducts = inventory.length;
      document.getElementById("totalProducts").innerText = totalProducts;
    }

    // Add item form submit event
    document
      .getElementById("addItemForm")
      .addEventListener("submit", function(event) {
        event.preventDefault();
        const itemName = document.getElementById("itemName").value;
        const itemQuantity = parseInt(
          document.getElementById("itemQuantity").value
        );

        if (itemName && !isNaN(itemQuantity)) {
          const newItem = {
            id: inventory.length + 1,
            name: itemName,
            quantity: itemQuantity,
          };
          inventory.push(newItem);
          renderInventory();
          document.getElementById("itemName").value = "";
          document.getElementById("itemQuantity").value = "";
        }
      });

    // Edit item form submit event
    document
      .getElementById("editItemForm")
      .addEventListener("submit", function(event) {
        event.preventDefault();
        const itemId = parseInt(document.getElementById("editItemId").value);
        const itemName = document.getElementById("editItemName").value;
        const itemQuantity = parseInt(
          document.getElementById("editItemQuantity").value
        );

        if (itemId && itemName && !isNaN(itemQuantity)) {
          const itemIndex = inventory.findIndex((item) => item.id === itemId);
          if (itemIndex !== -1) {
            inventory[itemIndex].name = itemName;
            inventory[itemIndex].quantity = itemQuantity;
            renderInventory();
            $("#editItemModal").modal("hide");
          }
        }
      });

    // Editbutton click event
    document
      .getElementById("inventoryTableBody")
      .addEventListener("click", function(event) {
        if (event.target.classList.contains("edit-btn")) {
          const itemId = parseInt(event.target.getAttribute("data-id"));
          const selectedItem = inventory.find((item) => item.id === itemId);

          document.getElementById("editItemId").value = selectedItem.id;
          document.getElementById("editItemName").value = selectedItem.name;
          document.getElementById("editItemQuantity").value =
            selectedItem.quantity;

          $("#editItemModal").modal("show");
        }
      });

    // Delete button click event
    document
      .getElementById("inventoryTableBody")
      .addEventListener("click", function(event) {
        if (event.target.classList.contains("delete-btn")) {
          const itemId = parseInt(event.target.getAttribute("data-id"));
          const itemIndex = inventory.findIndex((item) => item.id === itemId);
          if (itemIndex !== -1) {
            inventory.splice(itemIndex, 1);
            renderInventory();
          }
        }
      });

    // Initial render
    renderInventory();
  </script>


<script></script>
</body>

</html>