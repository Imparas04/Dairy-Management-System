<?php
include 'config.php';
include 'header.php';

// 1. Total Milk Collected (by Type)
$cow_sql = "SELECT SUM(quantity) as total FROM milk_collection WHERE milk_type = 'cow'";
$cow_res = $conn->query($cow_sql)->fetch_assoc();

$buff_sql = "SELECT SUM(quantity) as total FROM milk_collection WHERE milk_type = 'buffalo'";
$buff_res = $conn->query($buff_sql)->fetch_assoc();

// 2. Total Revenue from Orders
$sales_sql = "SELECT SUM(total_amount) as total FROM orders";
$sales_res = $conn->query($sales_sql)->fetch_assoc();

// 3. Total Payouts to Farmers
$payout_sql = "SELECT SUM(total_amount) as total FROM payments WHERE payment_status = 'Paid'";
$payout_res = $conn->query($payout_sql)->fetch_assoc();
?>

<div class="container mt-4">
    <h2>Business Analytics & Reports</h2>
    <hr>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white text-center p-3">
                <h6>Cow Milk (Total)</h6>
                <h4><?php echo number_format($cow_res['total'] ?? 0, 2); ?> Ltr</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white text-center p-3">
                <h6>Buffalo Milk (Total)</h6>
                <h4><?php echo number_format($buff_res['total'] ?? 0, 2); ?> Ltr</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white text-center p-3">
                <h6>Total Sales</h6>
                <h4>₹<?php echo number_format($sales_res['total'] ?? 0, 2); ?></h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white text-center p-3">
                <h6>Total Payouts</h6>
                <h4>₹<?php echo number_format($payout_res['total'] ?? 0, 2); ?></h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Recent Milk Collections (Last 10 Entries)
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Farmer</th>
                                <th>Type</th>
                                <th>Qty (Ltr)</th>
                                <th>Fat %</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent = $conn->query("SELECT mc.*, f.farmer_name 
                                                   FROM milk_collection mc 
                                                   JOIN farmers f ON mc.farmer_id = f.farmer_id 
                                                   ORDER BY mc.date DESC LIMIT 10");
                            while($r = $recent->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?php echo $r['date']; ?></td>
                                <td><?php echo $r['farmer_name']; ?></td>
                                <td><?php echo ucfirst($r['milk_type']); ?></td>
                                <td><?php echo $r['quantity']; ?></td>
                                <td><?php echo $r['fat_percent']; ?>%</td>
                                <td>₹<?php echo $r['total_amount']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>