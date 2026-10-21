<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KT Jewelry Store - Contact</title>
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
        .nav-link {
            color: #555555 !important;
        }
        .nav-link:hover {
            color: #bfa15f !important;
        }
        .card {
            background-color: #ffffff !important;
            border: none !important;
            border-radius: 10px;
        }
        .btn-primary, button[type="submit"] {
            background-color: #c5a059 !important;
            border-color: #c5a059 !important;
            color: white;
        }
        .btn-primary:hover, button[type="submit"]:hover {
            background-color: #b38f4d !important;
            border-color: #b38f4d !important;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="homepage.php">KT Jewelry Store</a>
            <div class="ms-auto d-flex align-items-center">
                <ul class="navbar-nav align-items-center flex-row">
                    <li class="nav-item me-3"><a class="nav-link" href="homepage.php">Homepage</a></li>
                    <li class="nav-item me-3"><a class="nav-link active" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm p-4">
                    <h2 class="text-center fw-bold mb-4" style="color: #bfa15f;">Contact Us</h2>
                    <p class="text-center text-muted mb-4">Have questions about our jewelry? Reach out to us anytime.</p>
                    
                    <div class="row mb-4">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <h5 class="fw-bold text-dark">📍 Address</h5>
                                <p class="text-muted small mb-0">123 Jewelry Lane, Yangon</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <h5 class="fw-bold text-dark">📞 Phone</h5>
                                <p class="text-muted small mb-0">+81 123 456 789</p>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded-3 h-100">
                                <h5 class="fw-bold text-dark">✉️ Email</h5>
                                <p class="text-muted small mb-0">support@ktjewelry.com</p>
                            </div>
                        </div>
                    </div>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message" class="form-control" rows="4" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>