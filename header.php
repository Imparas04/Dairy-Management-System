<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dairy Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="admin_dashboard.php">Dairy System</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="farmers.php">Farmers</a></li>
                    <li class="nav-item"><a class="nav-link" href="milk_collection.php">Collection</a></li>
                    <li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Inventory</a></li>
                    <li class="nav-item"><a class="nav-link" href="customers.php">Customers</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li> 
                    <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
                <?php elseif($_SESSION['role'] == 'farmer'): ?>
                    <li class="nav-item"><a class="nav-link" href="farmer_dashboard.php">Dashboard</a></li>
                <?php elseif($_SESSION['role'] == 'customer'): ?>
                    <li class="nav-item"><a class="nav-link" href="customer_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php">Shop Now</a></li>
                <?php endif; ?>
            </ul>

            <div class="ms-auto d-flex align-items-center">
                <span class="text-white me-3 small">
                    User: <strong><?php echo $_SESSION['name']; ?></strong>
                </span>
                <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-4">