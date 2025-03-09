<div class="container-fluid mt-4">
    <div class="row">
        <h1 class=" mb-3 ms-5 text-center text-info">Product List</h1>
        <div class="col-md-3">
            <form action="/gear_management/public/home/searchAndfilter" method="GET">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-warning">Category</h5>
                                <?php foreach ($categories as $category) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_id[]" value="<?php echo $category['id']; ?>" <?php echo in_array(
                                                                                                                                                        $category['id'],
                                                                                                                                                        $filterCategory = $filterCategory ?? []
                                                                                                                                                    ) ? 'checked' : ''; ?>>
                                        <label class="form-check-label"><?php echo $category['name']; ?></label>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <div class="mb-3">
                                <h5 class="text-warning">Price Range</h5>
                                <?php $priceRanges = [
                                    'min-200' => '$0 - $200',
                                    '200-500' => '$200 - $500',
                                    '500-1000' => '$500 - $1000',
                                    '1000-1500' => '$1000 - $1500',
                                    '1500-2000' => '$1500 - $2000',
                                    '2000-max' => 'Over $2000',
                                ];
                                foreach ($priceRanges as $range => $label) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="price[]" value="<?php echo $range; ?>" <?php echo in_array(
                                                                                                                                            $range,
                                                                                                                                            $filterPrice = $filterPrice ?? []
                                                                                                                                        ) ? 'checked' : ''; ?>>
                                        <label class="form-check-label"><?php echo $label; ?></label>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <h5 class="text-warning">Brand</h5>
                                <?php foreach ($brands as $brand) : ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand_id[]" value="<?php echo $brand['id']; ?>" <?php echo in_array(
                                                                                                                                                    $brand['id'],
                                                                                                                                                    $filterBrand = $filterBrand ?? []
                                                                                                                                                ) ? 'checked' : ''; ?>>
                                        <label class="form-check-label"><?php echo $brand['name']; ?></label>
                                    </div>
                                <?php endforeach ?>
                                <a href="/gear_management/public/product/create" class="btn btn-info mx-auto my-3">Add New Product</a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="filterButton" class="btn btn-primary ">Filter</button>
                </div>
            </form>
        </div>
        <div class="col-md-9">
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <?php if (!empty($product['imagefile'])) : ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['imagefile']); ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <?php endif; ?>
                            <div class="card-body position-relative padding-bottom">
                                <h3 class="card-title text-info"><?php echo $product['name']; ?></h3>
                                <p class="card-text">Description: <?php echo $product['description']; ?></p>
                                <h4 class="card-text text-danger position-absolute bottom-0">Price: $<?php echo $product['price']; ?></h4>
                            </div>
                            <div class="footer d-flex p-2 justify-content-between align-items-center">
                                <a href="/gear_management/public/product/showProduct/<?php echo $product['id']; ?>" class="btn btn-primary">Details</a>
                                <a href="/gear_management/public/product/update/<?php echo $product['id']; ?>" class="btn btn-dark">Update</a>
                                <a href="/gear_management/public/product/deleteProduct/<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center ">
                    <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php if ($i == $currentPage) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

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

    .pagination {
        margin-top: 20px;
    }

    .col-md-4 {
        padding: 0 10px;
    }

    .col-md-9 {
        padding: 0 10px;
    }
</style>