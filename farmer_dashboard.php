<?php
include 'header.php';

if($_SESSION['role']!='farmer'){
header("Location: login.php");
}

/* GET FARMER ID */

$user_id=$_SESSION['user_id'];

$stmt=$conn->prepare("SELECT farmer_id FROM farmers WHERE user_id=?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result=$stmt->get_result();
$farmer=$result->fetch_assoc();

$farmer_id=$farmer['farmer_id'];

/* TOTAL MILK */

$totalMilk=$conn->query("SELECT SUM(quantity) as total FROM milk_collection WHERE farmer_id=$farmer_id")->fetch_assoc();

/* TOTAL PAYMENT */

$totalPayment=$conn->query("SELECT SUM(total_amount) as total FROM milk_collection WHERE farmer_id=$farmer_id")->fetch_assoc();

/* MONTHLY SUMMARY */

$monthly=$conn->query("
SELECT 
DATE_FORMAT(date,'%Y-%m') as month,
SUM(quantity) as milk,
SUM(total_amount) as amount
FROM milk_collection
WHERE farmer_id=$farmer_id
GROUP BY month
ORDER BY month DESC
");

/* COLLECTION RECORDS */

$records=$conn->query("
SELECT * FROM milk_collection
WHERE farmer_id=$farmer_id
ORDER BY date DESC
");

/* PAYMENTS */

$payments=$conn->query("
SELECT * FROM payments
WHERE farmer_id=$farmer_id
ORDER BY month DESC
");

?>

<h2>Farmer Dashboard</h2>

<!-- SUMMARY CARDS -->

<div class="row mb-4">

<div class="col-md-6">

<div class="card dashboard-card">

<h5>Total Milk Supplied</h5>

<h3><?php echo $totalMilk['total']; ?> Liters</h3>

</div>

</div>

<div class="col-md-6">

<div class="card dashboard-card">

<h5>Total Earnings</h5>

<h3>₹ <?php echo $totalPayment['total']; ?></h3>

</div>

</div>

</div>

<!-- MILK COLLECTION TABLE -->

<div class="card p-3 mb-4">

<h4>Milk Collection Records</h4>

<table class="table table-bordered">

<tr>
<th>Date</th>
<th>Milk Type</th>
<th>Quantity</th>
<th>FAT %</th>
<th>Rate</th>
<th>Total</th>
</tr>

<?php while($r=$records->fetch_assoc()){ ?>

<tr>

<td><?php echo $r['date']; ?></td>
<td><?php echo $r['milk_type']; ?></td>
<td><?php echo $r['quantity']; ?></td>
<td><?php echo $r['fat_percent']; ?></td>
<td><?php echo $r['rate_per_liter']; ?></td>
<td><?php echo $r['total_amount']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<!-- MONTHLY SUMMARY -->

<div class="card p-3 mb-4">

<h4>Monthly Milk Summary</h4>

<table class="table table-bordered">

<tr>
<th>Month</th>
<th>Total Milk</th>
<th>Total Amount</th>
</tr>

<?php while($m=$monthly->fetch_assoc()){ ?>

<tr>

<td><?php echo $m['month']; ?></td>
<td><?php echo $m['milk']; ?> L</td>
<td>₹ <?php echo $m['amount']; ?></td>

</tr>

<?php } ?>

</table>

</div>

<!-- PAYMENT STATUS -->

<div class="card p-3 mt-4 shadow-sm">
    <h4>My Payment Status</h4>
    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Query check karo: Hum 'payment_status' select kar rahe hain
            $payments = $conn->query("SELECT * FROM payments WHERE farmer_id = $farmer_id ORDER BY payment_date DESC");
            
            if($payments->num_rows > 0):
                while($p = $payments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo date('d-M-Y', strtotime($p['payment_date'])); ?></td>
                    <td>₹<?php echo number_format($p['total_amount'], 2); ?></td>
                    <td><?php echo $p['payment_method'] ?? 'Cash'; ?></td>
                    <td>
                        <?php 
                        // YAHAN ERROR THI: status ki jagah payment_status check karo
                        $status = $p['payment_status'] ?? 'Pending'; 
                        
                        if($status == 'Paid') {
                            echo '<span class="badge bg-success">Paid</span>';
                        } else {
                            echo '<span class="badge bg-warning text-dark">Pending</span>';
                        }
                        ?>
                    </td>
                </tr>
                <?php endwhile; 
            else: ?>
                <tr><td colspan="4" class="text-center">No payment records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php include 'footer.php'; ?>