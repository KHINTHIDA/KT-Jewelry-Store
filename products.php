<?php
include 'config.php';
session_start();

function getZodiacSign($day, $month)
{
    if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) return "Aries";
    if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) return "Taurus";
    if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) return "Gemini";
    if (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) return "Cancer";
    if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) return "Leo";
    if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) return "Virgo";
    if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) return "Libra";
    if (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) return "Scorpio";
    if (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) return "Sagittarius";
    if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) return "Capricorn";
    if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) return "Aquarius";
    return "Pisces";
}

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_query = "SELECT * FROM products WHERE name LIKE '%$search_term%' ORDER BY id DESC";
} elseif (isset($_GET['birth_date']) && !empty($_GET['birth_date'])) {
    $date = new DateTime($_GET['birth_date']);
    $day = (int)$date->format('d');
    $month = (int)$date->format('m');
    $selected_zodiac = getZodiacSign($day, $month);
    $search_query = "SELECT * FROM products WHERE zodiac LIKE '%$selected_zodiac%' OR zodiac LIKE '%$selected_zodiac%'";
} else {
    $search_query = "SELECT * FROM products ORDER BY id DESC";
}

$products = mysqli_query($conn, $search_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fbf9f6 !important;
        }

        .navbar {
            background-color: #ffffff !important;
            border-bottom: 2px solid #f3f0ea !important;
        }

        .navbar-brand,
        .nav-link.active {
            color: #bfa15f !important;
            font-weight: bold;
        }

        .btn-primary,
        button[type="submit"] {
            background-color: #c5a059 !important;
            border-color: #c5a059 !important;
        }

        .btn-primary:hover,
        button[type="submit"]:hover {
            background-color: #b38f4d !important;
            border-color: #b38f4d !important;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0" style="color: #b38f4d;">Products</h3>
            <a href="homepage.php" class="text-decoration-none text-dark fw-semibold fs-5" style="color: #b38f4d !important;">Homepage</a>
            <form class="d-flex ms-3" action="products.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search jewelry..." required>
                    <button class="btn btn-outline-secondary btn-sm" type="submit" style="background-color: #c5a059; border-color: #c5a059; color: white;">
                        🔍
                    </button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm p-4 mb-4 bg-white text-center rounded-4 border-0">
            <h4 class="mb-3 fw-bold text-secondary">Find Your Zodiac Jewelry by Birthday</h4>
            <form method="GET" action="" class="row justify-content-center g-3 align-items-center">
                <div class="col-md-4">
                    <input type="date" name="birth_date" class="form-control" required value="<?php echo htmlspecialchars($_GET['birth_date'] ?? ''); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Find Sign</button>
                </div>
                <?php if (!empty($selected_zodiac)): ?>
                    <div class="col-md-2">
                        <a href="products.php" class="btn btn-secondary w-100">Reset</a>
                    </div>
                <?php endif; ?>
            </form>

            <?php if (!empty($selected_zodiac)): ?>
                <div class='mt-3 alert alert-primary d-inline-block px-4 py-2 mb-0'>
                    Your Zodiac Sign is: <strong><?php echo $selected_zodiac; ?></strong>
                </div>
            <?php endif; ?>
        </div>

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
                    <p class="text-muted fs-5">No products found for this Zodiac sign.</p>
                    <a href="products.php" class="btn btn-primary btn-sm">View All Products</a>
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