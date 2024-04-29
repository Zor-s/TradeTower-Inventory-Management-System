<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./index.css">

    <style>
        .cc-div1 {
            padding: 1%;
            padding-left: 5%;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary m-2 rounded-4 shadow-lg cc-navbar fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand"><img width="80" height="80" src="logo.png" alt="logo.png"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item fs-5">
                        <a class="nav-link active" aria-current="page"
                            href="./adminProductsDashboard.php">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item fs-5">
                        <a class="nav-link active cc-active-link" aria-current="page" href="./adminTransactionInformation.php">Transaction Information</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 10%;"></div>
    <div class="cc-div-styles p-3 rounded-4 shadow-lg text-lg-center">
        <p>You have no orders yet. Order now!</p>
    </div>
    <div class="cc-div-styles cc-div1 rounded-4 shadow-lg">
        <p><b>1. Zors</b></p>
        <p>Popberry pie 3x</p>
        <br>
        <p>Status: To ship</p>
    </div>

<?php 
include './connector.php';
$DB = new connector();

?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>