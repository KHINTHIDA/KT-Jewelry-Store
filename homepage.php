<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store</title>
</head>
<body>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .gold-color {
            color: #b8860b;
        }

        .btn-gold {
            background-color: #b8860b;
            color: white;
        }

        .btn-gold:hover {
            background-color: #996f09;
            color: white;
        }

        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('img.jpg') center/cover;
            height: 350px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-section {

            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('img.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold gold-color" href="#">KT Jewelry Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav gap-3">
                    <li class="nav-item"><a class="nav-link active" href="homepage.php" style="color: #af9564 !important;">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php" style="color: #af9564 !important;">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="RegisterForm.php" style="color: #af9564 !important;">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="Login.php" style="color: #af9564 !important;">Log in</a></li>
                    <li class="nav-item"><a class="nav-link" href="Categories.php" style="color: #af9564 !important;">Categories</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section mb-5" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('img.jpg'); background-size: cover; background-position: center; padding: 100px 0;">
        <div class="container text-center">
            <h1 class="display-5 fw-bold text-white">Enjoy Your Zodiac Jewelry</h1>
            <p class="fs-5 text-white">Discover World-Class Zodiac Jewelry Collections</p>
            <a href="#products" class="btn btn-light btn-lg px-4 mt-2">SEE COLLECTION</a>
        </div>
    </div>

    <div class="container mb-5" id="products">

                </form>
            </div>
        </div>

        <div class="row g-4">

            <?php
            $products = [
                ["name" => "Aries Ruby Ring", "zodiac" => "Aries", "price" => "150", "image" => "./imgs/aries.jpg"],
                ["name" => "Taurus Emerald Necklace", "zodiac" => "Taurus", "price" => "200", "image" => "./imgs/taurus.jpg"],
                ["name" => "Gemini Pearl Bracelet", "zodiac" => "Gemini", "price" => "120", "image" => "./imgs/gemini.jpg"],
                ["name" => "Cancer Moonstone Pendant", "zodiac" => "Cancer", "price" => "180", "image" => "./imgs/cancer.jpg"]
            ];

            foreach ($products as $row) {
                echo '
                <div class="col-sm-6 col-md-3">
                    <div class="card h-100 shadow-sm border-0 p-3 text-center">
                        <img src="' . $row['image'] . '" class="card-img-top object-fit-contain mx-auto" style="height: 180px; width: 100%;" alt="' . $row['name'] . '">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-6 fw-bold">' . $row['name'] . '</h5>
                            <p class="card-text text-muted small mb-2">Zodiac: ' . $row['zodiac'] . '</p>
                            <p class="card-text fw-bold gold-color mt-auto fs-5">$' . $row['price'] . '</p>
                        </div>
                    </div>
                </div>
                ';
            }
            ?>

        </div>
    </div>

</body>

</html>