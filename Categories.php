<?php
include 'config.php';
session_start();

$sort_order = "DESC"; 
$sort_column = "id";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = "SELECT * FROM products WHERE name LIKE '%$search_term%' ORDER BY id DESC";
} else {
    if (isset($_GET['sort'])) {
        if ($_GET['sort'] == 'lowest_price') {
            $sort_column = "price";
            $sort_order = "ASC";
        } elseif ($_GET['sort'] == 'highest_price') {
            $sort_column = "price";
            $sort_order = "DESC";
        } elseif ($_GET['sort'] == 'latest') {
            $sort_column = "id";
            $sort_order = "DESC";
        }
    }
    $search_query = "SELECT * FROM products ORDER BY $sort_column $sort_order";
}

$products = mysqli_query($conn, $search_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store - Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #fbf9f6 !important;
    }
    .navbar {
        background-color: #ffffff !important;
        border-bottom: 2px solid #f3f0ea !important;
    }
    .navbar-brand, .nav-link.active {
        color: #bfa15f !important;
        font-weight: bold;
    }
    .btn-primary, button[type="submit"] {
        background-color: #c5a059 !important;
        border-color: #c5a059 !important;
    }
    .btn-primary:hover, button[type="submit"]:hover {
        background-color: #b38f4d !important;
        border-color: #b38f4d !important;
    }
</style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-dark" href="homepage.php">Homepage</a>
            
            <div class="ms-auto d-flex align-items-center">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark fw-semibold px-3 py-1" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #b38f4d !important;">
                            Categories
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 rounded-3" aria-labelledby="categoryDropdown">
                            <li><a class="dropdown-item py-2" href="categories.php" style="color: #b38f4d !important;">All Products</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="categories.php?sort=latest" style="color: #b38f4d !important;">Latest Items</a></li>
                            <li><a class="dropdown-item py-2" href="categories.php?sort=lowest_price" style="color: #b38f4d !important;">Lowest Price</a></li>
                            <li><a class="dropdown-item py-2" href="categories.php?sort=highest_price" style="color: #b38f4d !important;">Highest Price</a></li>
                            <li><a class="dropdown-item py-2" href="contact.php" style="color: #b38f4d !important;">Contact Us</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2" href="logout.php" style="color: #b38f4d !important;">Logout</a></li>
                        </ul>
                    </li>
                </ul>

                <form class="d-flex ms-3" action="categories.php" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search item..." required>
                        <button class="btn btn-outline-secondary btn-sm" type="submit" style="background-color: #c5a059; border-color: #c5a059; color: white;">
                            🔍
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <div class="row g-4">
            <?php if ($products && mysqli_num_rows($products) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($products)): ?>
                    <?php 
                        $row_name = $row['product_name'] ?? ($row['name'] ?? 'No Name');
                        $row_zodiac = $row['zodiac_sign'] ?? ($row['zodiac'] ?? '');
                        $row_price = $row['price'] ?? 0;
                        $row_image = trim($row['img'] ?? ($row['image'] ?? ''));
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="card h-100 shadow-sm border-0 bg-white">
                            <?php if (!empty($row_image)): ?>
                                <img src="<?php echo htmlspecialchars($row_image); ?>" class="card-img-top" alt="Product Image" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="text-center text-muted bg-secondary-subtle py-5" style="height: 200px;">No Image</div>
                            <?php endif; ?>
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($row_name); ?></h5>
                                <p class="text-muted small mb-2">Zodiac: <span class="badge bg-secondary"><?php echo htmlspecialchars($row_zodiac); ?></span></p>
                                <p class="text-dark fw-bold fs-5">$<?php echo number_format((float)$row_price, 2); ?></p>
                                <button type="button" class="btn btn-primary w-100 btn-sm fw-bold" onclick="buyProduct(<?php echo $row['id']; ?>, <?php echo $row['price']; ?>)">
                                    Buy
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted fs-5">No products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function buyProduct(productId, price) {
        if (confirm("Are you sure you want to buy this product?")) {
            let quantity = prompt("Enter quantity:", "1");
            if (quantity !== null && quantity !== "" && !isNaN(quantity) && quantity > 0) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = 'place_order.php';

                let pIdInput = document.createElement('input');
                pIdInput.type = 'hidden';
                pIdInput.name = 'product_id';
                pIdInput.value = productId;
                form.appendChild(pIdInput);

                let priceInput = document.createElement('input');
                priceInput.type = 'hidden';
                priceInput.name = 'price';
                priceInput.value = price;
                form.appendChild(priceInput);

                let qtyInput = document.createElement('input');
                qtyInput.type = 'hidden';
                qtyInput.name = 'quantity';
                qtyInput.value = quantity;
                form.appendChild(qtyInput);

                document.body.appendChild(form);
                form.submit();
            } else if (quantity !== null) {
                alert("Please enter a valid quantity.");
            }
        }
    }
    </script>
</body>
</html>