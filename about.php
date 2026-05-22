<?php
// Project: Dairy Management System
// Developer: paras choudhary 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Digital Dairy Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            color: #444;
        }

        .about-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1500595046743-cd271d694d30?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .glass-card:hover {
            transform: translateY(-10px);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
        }

        .team-img {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 50px;
            font-weight: 700;
        }

        .section-title::after {
            content: '';
            position: absolute;
            display: block;
            width: 50px;
            height: 3px;
            background: #2e7d32;
            bottom: 0;
            left: calc(50% - 25px);
        }

        .stats-box {
            background: #2e7d32;
            color: white;
            padding: 50px 0;
        }
    </style>
</head>
<body>

    <div class="about-hero">
        <div class="container">
            <h1 class="display-3 fw-bold">Our Story</h1>
            <p class="lead">Revolutionizing Dairy Management through Digital Excellence.</p>
        </div>
    </div>

    <div class="container my-5 py-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="icon-box"><i class="fas fa-bullseye"></i></div>
                    <h4>Our Mission</h4>
                    <p class="text-muted">To provide a seamless digital bridge between local milk producers and consumers, ensuring fair trade and pure quality.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="icon-box"><i class="fas fa-eye"></i></div>
                    <h4>Our Vision</h4>
                    <p class="text-muted">To become the leading digital platform for dairy cooperatives, promoting sustainability and health in every household.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="icon-box"><i class="fas fa-check-circle"></i></div>
                    <h4>Quality Policy</h4>
                    <p class="text-muted">We adhere to strict testing standards for fat, SNF, and purity, ensuring only the best reaches your table.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Why Digital Dairy?</h2>
                <p>Traditionally, dairy farming involved heaps of paperwork and manual calculations which led to errors and payment delays. This system, developed by <strong>Yash Potdar and Prathamesh Patil</strong>, eliminates these hurdles using modern technology.</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Real-time Milk Collection Tracking</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Transparent Pricing based on Fat Content</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Secure Digital Inventory for Dairy Products</li>
                    <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Instant Billing and Order Management</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1528498033053-3564afd7944d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow" alt="Dairy Technology">
            </div>
        </div>
    </div>

    <div class="stats-box text-center mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h2 class="fw-bold">25+</h2>
                    <p class="mb-0">Happy Farmers</p>
                </div>
                 
                <div class="col-md-3">
                    <h2 class="fw-bold">8+</h2>
                    <p class="mb-0">Dairy Products</p>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold">100%</h2>
                    <p class="mb-0">Pure Quality</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 text-center">
        <h2 class="section-title">The Developers</h2>
        <div class="row justify-content-center g-5">
            <div class="col-md-4">
                <img src="assets/images/prathamesh.jpg" class="team-img mb-3" alt="Prathamesh Patil">
                <h5 class="fw-bold">Paras Choudhary</h5>
                <p class="text-success fw-bold">Full Stack Developer</p>
                <div class="socials">
                    <a href="#" class="text-muted me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-github fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4">
                <img src="assets/images/yash.jpg" class="team-img mb-3" alt="Yash Potdar">
                <h5 class="fw-bold">Paras Choudhary</h5>
                <p class="text-success fw-bold">Database Administrator</p>
                <div class="socials">
                    <a href="#" class="text-muted me-2"><i class="fab fa-linkedin fa-lg"></i></a>
                    <a href="#" class="text-muted"><i class="fab fa-github fa-lg"></i></a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Digital Dairy Solutions. Developed by Paras Choudhary.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>