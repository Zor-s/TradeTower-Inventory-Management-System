<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./index.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary m-2 rounded-4 shadow-lg cc-navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand"><img width="80" height="80" src="logo.png" alt="logo.png"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item fs-5">
                        <a class="nav-link active cc-active-link" aria-current="page" href="./adminProductsDashboard">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item fs-5">
                        <a class="nav-link active" aria-current="page" href="./adminTransactionInformation.php">Transaction Information</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="margin-top: 10%;"></div>
    <div class="cc-div-styles p-3 rounded-4 shadow-lg text-lg-center">
        <p>We have no products currently selling.</p>
    </div>

    <div class="cc-div-styles p-3 px-5 rounded-4 shadow-lg ">
        <p>Scarrot wine 30x</p>


        <div class="d-flex">
            <div style="margin-right: 1%;">
                <div> <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal">
                        Edit
                    </button></div>
            </div>
            <div>
                <div> <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#orderModal">
                        Delete
                    </button></div>
            </div>
        </div>



    </div>

    <div class="cc-div-styles p-3 rounded-4 shadow-lg text-lg-center">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#orderModal">
            Add a new product
        </button>
    </div>



    <!-- Modal -->
    <div class="modal fade" data-bs-backdrop="static" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="orderModalLabel">Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Amount: </p>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-secondary" onclick="decrement()">-</button>
                        <input type="text" class="form-control" id="counter" value="1" readonly>
                        <button type="button" class="btn btn-secondary" onclick="increment()">+</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>