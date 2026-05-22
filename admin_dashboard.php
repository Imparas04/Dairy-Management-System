<?php
include 'config.php';
include 'header.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
}

/* Data Fetching Logic */
$farmers = $conn->query("SELECT COUNT(*) as total FROM farmers")->fetch_assoc()['total'];
$customers = $conn->query("SELECT COUNT(*) as total FROM customers")->fetch_assoc()['total'];
$todayMilk = $conn->query("SELECT SUM(quantity) as total FROM milk_collection WHERE date = CURDATE()")->fetch_assoc()['total'];
$cowMilk = $conn->query("SELECT SUM(quantity) as total FROM milk_collection WHERE milk_type='cow'")->fetch_assoc()['total'];
$buffaloMilk = $conn->query("SELECT SUM(quantity) as total FROM milk_collection WHERE milk_type='buffalo'")->fetch_assoc()['total'];
$orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
$profit = $conn->query("SELECT SUM(total_amount) as total FROM orders")->fetch_assoc()['total'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Admin Dashboard</h2>
    <a href="about.php" class="btn btn-primary shadow-sm">
        <i class="fas fa-info-circle me-1"></i> About Us
    </a>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card dashboard-card bg-primary text-white border-0 shadow-sm p-3">
            <h5>Total Farmers</h5>
            <h2 class="fw-bold"><?php echo $farmers; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card bg-success text-white border-0 shadow-sm p-3">
            <h5>Total Customers</h5>
            <h2 class="fw-bold"><?php echo $customers; ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card bg-info text-white border-0 shadow-sm p-3">
            <h5>Today's Milk</h5>
            <h2 class="fw-bold"><?php echo $todayMilk ?: 0; ?> L</h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card dashboard-card bg-warning text-dark border-0 shadow-sm p-3">
            <h5>Total Orders</h5>
            <h2 class="fw-bold"><?php echo $orders; ?></h2>
            <a href="orders.php" class="btn btn-dark btn-sm mt-2">View Orders</a> 
        </div>
    </div>
</div>

<br>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 text-center">
            <h5 class="text-muted">Total Cow Milk</h5>
            <h2 class="text-primary fw-bold"><?php echo $cowMilk ?: 0; ?> L</h2>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm p-4 text-center">
            <h5 class="text-muted">Total Buffalo Milk</h5>
            <h2 class="text-danger fw-bold"><?php echo $buffaloMilk ?: 0; ?> L</h2>
        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-12">
        <div class="card p-4 border-0 shadow-sm">
            <h4 class="mb-4">Milk Collection Analysis (Cow vs Buffalo)</h4>
            <div style="height: 400px; width: 100%;">
                <canvas id="milkChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('milkChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Cow Milk', 'Buffalo Milk'],
        datasets: [{
            label: 'Liters Collected',
            data: [<?php echo $cowMilk ?: 0 ?>, <?php echo $buffaloMilk ?: 0 ?>],
            backgroundColor: ['#0d6efd', '#dc3545'],
            borderRadius: 8,
            barThickness: 100
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: { display: true, text: 'Quantity in Liters' }
            }
        }
    }
});
</script>

<?php include 'footer.php'; ?>