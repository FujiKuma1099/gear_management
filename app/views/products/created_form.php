<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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

        /* Điều chỉnh nút Save và Add Category/Brand */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Add New Product</h2>
        <div class="form-container">
            <form action="/gear_management/public/product/addProduct/" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Product Name:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="form-group radio-group">
                    <label class="form-label">Category:</label>
                    <div>
                        <input type="radio" class="form-check-input" name="category_id" value="1" required> Laptop Gaming</br>
                        <input type="radio" class="form-check-input" name="category_id" value="2"> Computer Mouse</br>
                        <input type="radio" class="form-check-input" name="category_id" value="3"> Keyboard</br>
                        <input type="radio" class="form-check-input" name="category_id" value="4"> Headphones
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Brand:</label>
                    <select class="form-select" name="brand_id" required>
                        <option value="" selected disabled>Choose...</option>
                        <option value="1">1. Acer</option>
                        <option value="2">2. ASUS</option>
                        <option value="3">3. Dell</option>
                        <option value="4">4. HP</option>
                        <option value="5">5. Lenovo</option>
                        <option value="6">6. MSI</option>
                        <option value="7">7. Logitech</option>
                        <option value="8">8. Razer</option>
                        <option value="9">9. SteelSeries</option>
                        <option value="10">10. Corsair</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Price: $</label>
                    <input type="number" class="form-control" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Stock:</label>
                    <input type="number" class="form-control" name="stock" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Description:</label>
                    <textarea class="form-control" rows="3" name="description"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Imagefile:</label>
                    <input type="file" class="form-control" name="imagefile">
                </div>

                <div class="form-actions">
                    <a href="/gear_management/public/index.php" class="btn btn-secondary">Back to Homepage</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>