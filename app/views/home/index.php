<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            padding: 0;
        }

        .navbar-brand img {
            height: 70px;
        }

        .search-bar {
            flex-grow: 1;
            max-width: 600px;
            margin: 0 20px;
        }

        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
        }

        .search-button {
            background-color: chocolate;
            padding: 8px 12px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 2px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/gear_management/public/home/index">
                <img src="/gear_management/public/assets/topgear.png" alt="Logo">
            </a>
            <form action="/gear_management/public/home/searchAndfilter" method="$_GET" class="d-flex search-bar justify-content-center ms-5 ">
                <input class="form-control me-1" type="search" name="search" placeholder="Bạn cần tìm gì..." aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button class="btn btn-outline-success search-button" type="submit">
                    <i class="fas fa-search"></i>Tìm kiếm
                </button>
            </form>
            <div class="dropdown ms-3">
                <?php if (isset($_SESSION['name'])): ?>
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> <?php echo $_SESSION['name']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="/gear_management/public/user/logout">Log out</a></li>
                    </ul>
                <?php else: ?>
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="/gear_management/public/user/formLoginSignup">Log in</a></li>
                        <li><a class="dropdown-item" href="/gear_management/public/user/formLoginSignup">Sign up</a></li>
                    </ul>
                <?php endif; ?>
                <a class="btn btn-outline-dark ms-3 me-3" href="#">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </nav>

    <?php
    $products = $data['products'];
    $categories = $data['categories'];
    $brands = $data['brands'];

    include __DIR__ . '/../products/index.php';
    ?>

    <footer class="bg-light text-center text-lg-start mt-4">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2025 Bản quyền thuộc về Nhật Minh
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>