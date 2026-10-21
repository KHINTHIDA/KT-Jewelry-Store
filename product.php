<?php
include('header.php');
include('config.php');

function getZodiacSign($day, $month) {
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
    if (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) return "Pisces";
    return "";
}

$userZodiac = "";
if (isset($_POST['dob']) && !empty($_POST['dob'])) {
    $dob = new DateTime($_POST['dob']);
    $day = (int)$dob->format('d');
    $month = (int)$dob->format('m');
    $userZodiac = getZodiacSign($day, $month);
    
    $query = "SELECT * FROM products WHERE zodiac = '$userZodiac' ORDER BY id DESC";
} else {
    $query = "SELECT * FROM products ORDER BY id DESC";
}

$products = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        .container {
            text-align: center;
            padding: 20px;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .product-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .product-card {
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 20px;
            width: 200px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .product-card img {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-section">
        <form method="POST">
            <label>Select Your Birthday: </label>
            <input type="date" name="dob" required>
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if ($userZodiac != ""): ?>
        <h3>Your Zodiac Sign: <?php echo $userZodiac; ?></h3>
    <?php endif; ?>

    <div class="product-grid">
        <?php while($row = $products->fetch_assoc()): ?>
            <div class="product-card">
                <img src="<?php echo $row['image'] ?? 'img.jpg'; ?>" alt="Product Image">
                <h4><?php echo $row['name']; ?></h4>
                <p>Zodiac: <?php echo $row['zodiac']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>