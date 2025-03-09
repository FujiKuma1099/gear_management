<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Tùy chỉnh form để gọn hơn */
        .form-container {
            max-width: 800px;
            /* Giới hạn độ rộng của form */
            margin: 0 auto;
            /* Căn giữa form */
        }

        /* Đảm bảo các input và label nằm trên cùng một dòng */
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .form-group label {
            flex: 0 0 150px;
            /* Chiều rộng cố định cho label */
            margin-right: 10px;
            /* Khoảng cách giữa label và input */
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            flex: 1;
            /* Input chiếm phần còn lại của dòng */
        }

        /* Điều chỉnh radio buttons */
        .form-group.radio-group {
            display: block;
            /* Radio buttons hiển thị dạng block */
        }

        .form-group.radio-group label {
            flex: none;
            /* Không áp dụng flex cho label của radio */
        }
    </style>
</head>

<body>
    <div class="form-container mt-5">
        <h1 class="text-center">Update Product</h1>
        <form action="/gear_management/public/product/updateProduct/<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data" class="form group">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $product['name']; ?>">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <div>
                    <input type="radio" class="form-check-input" name="category" value="1" <?php if ($product['category_id'] == 1) echo 'checked'; ?>> Laptop Gaming<br>
                    <input type="radio" class="form-check-input" name="category" value="2" <?php if ($product['category_id'] == 2) echo 'checked'; ?>> Computer Mouse<br>
                    <input type="radio" class="form-check-input" name="category" value="3" <?php if ($product['category_id'] == 3) echo 'checked'; ?>> Keyboard<br>
                    <input type="radio" class="form-check-input" name="category" value="4" <?php if ($product['category_id'] == 4) echo 'checked'; ?>> Headphones<br>
                </div>
                <div class="mb-3">
                    <label for="brand" class="form-label">Brand</label>
                    <select class="form-select" name="brand">
                        <option value="1" <?php if ($product['brand_id'] == 1) echo 'selected'; ?>>Acer
                        <option value="2" <?php if ($product['brand_id'] == 2) echo 'selected'; ?>>ASUS
                        <option value="3" <?php if ($product['brand_id'] == 3) echo 'selected'; ?>>Dell
                        <option value="4" <?php if ($product['brand_id'] == 4) echo 'selected'; ?>>HP
                        <option value="5" <?php if ($product['brand_id'] == 5) echo 'selected'; ?>>Lenovo
                        <option value="6" <?php if ($product['brand_id'] == 6) echo 'selected'; ?>>MSi
                        <option value="7" <?php if ($product['brand_id'] == 7) echo 'selected'; ?>>Logitech
                        <option value="8" <?php if ($product['brand_id'] == 8) echo 'selected'; ?>>Razer
                        <option value="9" <?php if ($product['brand_id'] == 9) echo 'selected'; ?>>StellSeries
                        <option value="10" <?php if ($product['brand_id'] == 10) echo 'selected'; ?>>Consair
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" value="<?php echo $product['stock']; ?>">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"><?php echo $product['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <?php
                    if (!empty($product['imagefile'])) : ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($product['imagefile']); ?>" width="350px" height='250px'>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="image" name="imagefile">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>