<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store</title>
    <style>
        
        .header {
            overflow: hidden;
            background-color: #fde0ef;
            padding: 20px 10px;
        }

        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            float: left;
        }

        .store-title {
            font-size: 20px;
            font-weight: bold;
            color: #37f750;
        }

        
        .header-right {
            float: right;
        }

        .header-right a {
            float: left;
            color: #37f750;
            text-align: center;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            line-height: 25px;
            border-radius: 4px;
        }

        .header-right a:hover {
            background-color: #ddd;
            color: black;
        }

        
        @media screen and (max-width: 500px) {
            .header-right a, .logo-container {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div class="header">
    
    <div class="logo-container">
        <img src="img.jpg" style="width: 100px; height: auto;">
        <span class="store-title">KT Jewelry Store</span>
    </div>

    
    <div class="header-right">
        <a class="active" href="products.php">Products</a>
        <a class="active" href="categories.php">Categories</a>
        <a class="active" href="Login.php">Log in</a>
    </div>
</div>