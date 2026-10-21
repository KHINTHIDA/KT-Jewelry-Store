<?php
include 'config.php';
session_start();

if (isset($_POST['save_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $zodiac_sign = mysqli_real_escape_string($conn, $_POST['zodiac_sign']);
    $price = floatval($_POST['price']);
    $img = mysqli_real_escape_string($conn, $_POST['image']);
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    if ($product_id > 0) {
       
        $sql = "UPDATE products SET name='$product_name', zodiac='$zodiac_sign', price='$price', img='$img' WHERE id=$product_id";
    } else {

        $sql = "INSERT INTO products (name, zodiac, price, img) VALUES ('$product_name', '$zodiac_sign', '$price', '$img')";
    }
    mysqli_query($conn, $sql);
    header("Location: AddProduct.php");
    exit();
}


if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: AddProduct.php");
    exit();
}


$edit_data = ['id' => '', 'name' => '', 'zodiac' => '', 'price' => '', 'img' => ''];
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    if ($edit_res && mysqli_num_rows($edit_res) > 0) {
        $edit_data = mysqli_fetch_assoc($edit_res);
    }
}

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container-fluid px-4 py-3">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>KT Jewelry - Admin Dashboard</h2>
        <div>
            <a href="homepage.php" class="btn btn-outline-primary btn-sm">Homepage</a>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4><?php echo !empty($edit_data['id']) ? 'Edit Product' : 'Add New Product'; ?></h4>
            <form method="POST" class="row g-3 align-items-end">
                <input type="hidden" name="product_id" value="<?php echo $edit_data['id']; ?>">
                
                <div class="col-md-3">
                    <label class="form-label text-muted small">Product Name *</label>
                    <input type="text" class="form-control" name="product_name" placeholder="e.g. Aries Ruby Ring" value="<?php echo htmlspecialchars($edit_data['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Zodiac Sign *</label>
                    <input type="text" class="form-control" name="zodiac_sign" placeholder="e.g. Aries" value="<?php echo htmlspecialchars($edit_data['zodiac'] ?? ''); ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label text-muted small">Price ($) *</label>
                    <input type="number" step="0.01" class="form-control" name="price" placeholder="e.g. 150" value="<?php echo htmlspecialchars($edit_data['price'] ?? ''); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted small">Image Path *</label>
                    <input type="text" class="form-control" name="image" placeholder="imgs/aries.jpg" value="<?php echo htmlspecialchars($edit_data['img'] ?? ''); ?>" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="save_product" class="btn btn-danger w-100 fw-bold text-white">
                        <?php echo !empty($edit_data['id']) ? 'Update Item' : '+ Save Item'; ?>
                    </button>
                    <?php if (!empty($edit_data['id'])): ?>
                        <a href="AddProduct.php" class="btn btn-secondary btn-sm w-100 mt-1">Cancel</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>IMAGE</th>
                        <th>NAME</th>
                        <th>ZODIAC</th>
                        <th>PRICE</th>
                        <th class="text-end pe-3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($products && mysqli_num_rows($products) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($products)): ?>
                            <?php $row_image = trim($row['img'] ?? ''); ?>
                            <tr>
                                <td class="ps-3"><?php echo htmlspecialchars($row['id']); ?></td>
                                <td>
                                    <?php if (!empty($row_image)): ?>
                                        <img src="<?php echo htmlspecialchars($row_image); ?>" alt="Product" style="width: 45px; height: 45px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <span class="text-muted small">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['zodiac']); ?></span></td>
                                <td>$<?php echo number_format((float)$row['price'], 2); ?></td>
                                <td class="text-end pe-3">
                                    <a href="AddProduct.php?edit=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm me-1">Edit</a>
                                    <a href="AddProduct.php?delete=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>