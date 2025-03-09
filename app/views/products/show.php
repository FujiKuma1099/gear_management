<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card .card-img-top {
            object-fit: cover;
            height: 250px;
            max-width: 100%;
        }


        .product-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-card .card-body a {
            margin-top: auto;
        }
    </style>
</head>

<body>
    <div class="container col-md-4 mb-4 mt-4">
        <div class="card product-card">
            <?php
 if (!empty($product['imagefile'])) : ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['imagefile']); ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
            <?php endif; ?>
            <div class="card-body position-relative padding-bottom">
                <h3 class="card-title text-info">Name: <?php echo $product['name']; ?></h3>
                <p class="card-text">Category: 
                    <?php switch ($product['category_id']){
                        case 1:
                            echo "Laptop Gaming";
                            break;
                        case 2:
                            echo "Computer Mouse";
                            break;
                        case 3:
                            echo "Keyboard";
                            break;
                        case 4:
                            echo "Headphones";
                            break;
                    }?></p>
                <p class="card-text">Brand: 
                    <?php switch ($product['brand_id']){
                        case 1:
                            echo "Acer";
                            break;
                        case 2:
                            echo "ASUS";
                            break;
                        case 3:
                            echo "Dell";
                            break;
                        case 4:
                            echo "HP";
                            break;
                        case 5:
                            echo "Lenovo";
                            break;
                        case 6:
                            echo "MSi";
                            break;
                        case 7:
                            echo "Logitech";
                            break;
                        case 8:
                            echo "Razer";
                            break;
                        case 9:
                            echo "StellSeries";
                            break;
                        case 10:
                            echo "Consair";
                            break;
                    } ?></p>
                <p class="card-text">Stock: <?php echo $product['stock']; ?></p>
                <p class="card-text">Description: <?php echo $product['description']; ?></p>
                <h4 class="card-text text-danger position-absolute bottom-0">Price: $<?php echo $product['price']; ?></h4>
            </div>
            <div>
                <button class="btn btn-primary justify-content-end mt-3" onclick="window.history.back()">Back</button>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>