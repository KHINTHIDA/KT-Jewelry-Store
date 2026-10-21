<?php
include 'config.php';
session_start();

date_default_timezone_set('Asia/Tokyo');

if (!isset($_SESSION['id']) && !isset($_SESSION['customer_id']) && !isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in or register first.'); window.location.href='Login.php';</script>";
    exit();
}

$customer_id = $_SESSION['id'] ?? ($_SESSION['customer_id'] ?? $_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $total_price = $price * $quantity;
    $order_date = date('Y-m-d H:i:s');

    $insert_query = "INSERT INTO orders (customer_id, total_price, order_date) VALUES ('$customer_id', '$total_price', '$order_date')";
    
    if (mysqli_query($conn, $insert_query)) {
        $order_id = mysqli_insert_id($conn);
        
        $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'order_items'");
        if ($check_table && mysqli_num_rows($check_table) > 0) {
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$product_id', '$quantity', '$price')");
        }

        echo "<script>alert('Order placed successfully!'); window.location.href='categories.php';</script>";
    } else {
        echo "<script>alert('Database Error: " . mysqli_error($conn) . "'); window.location.href='categories.php';</script>";
    }
} else {
    header("Location: categories.php");
    exit();
}
?>