<?php
include 'config.php';
include 'header.php';

// Handle "Mark as Paid" action
if (isset($_GET['pay_id'])) {
    $p_id = $_GET['pay_id'];
    $conn->query("UPDATE payments SET payment_status = 'Paid', payment_date = CURDATE() WHERE payment_id = $p_id");
    header("Location: payments.php?msg=Paid Successfully");
}

// Handle "Generate Payment" action
if (isset($_POST['generate_payment'])) {
    $farmer_id = $_POST['farmer_id'];
    $month = $_POST['month']; // Format: YYYY-MM

    // Calculate totals for that farmer in that month
    $sql = "SELECT SUM(quantity) as total_qty, SUM(total_amount) as total_amt 
            FROM milk_collection 
            WHERE farmer_id = '$farmer_id' AND DATE_FORMAT(date, '%Y-%m') = '$month'";
    
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();

    if ($data['total_qty'] > 0) {
        $total_liters = $data['total_qty'];
        $total_amount = $data['total_amt'];

        // Check if payment record already exists to avoid duplicates
        $check = $conn->query("SELECT * FROM payments WHERE farmer_id = '$farmer_id' AND month = '$month'");
        if ($check->num_rows == 0) {
            $conn->query("INSERT INTO payments (farmer_id, month, total_liters, total_amount, payment_status) 
                          VALUES ('$farmer_id', '$month', '$total_liters', '$total_amount', 'Pending')");
        }
    }
}
?>

<div class="container">
    <h2>Farmer Payment Management</h2>

    <div class="card p-3 mb-4">
        <h4>Generate New Payout</h4>
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <select name="farmer_id" class="form-control" required>
                    <option value="">Select Farmer</option>
                    <?php
                    $farmers = $conn->query("SELECT * FROM farmers");
                    while($f = $farmers->fetch_assoc()) {
                        echo "<option value='".$f['farmer_id']."'>".$f['farmer_name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="month" name="month" class="form-control" required>
            </div>
            <div class="col-md-4">
                <button type="submit" name="generate_payment" class="btn btn-primary w-100">Calculate & Add to List</button>
            </div>
        </form>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Farmer</th>
                <th>Month</th>
                <th>Total Liters</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $payments = $conn->query("SELECT p.*, f.farmer_name FROM payments p JOIN farmers f ON p.farmer_id = f.farmer_id ORDER BY p.payment_id DESC");
            while($row = $payments->fetch_assoc()):
            ?>
            <tr>
                <td><?php echo $row['farmer_name']; ?></td>
                <td><?php echo $row['month']; ?></td>
                <td><?php echo $row['total_liters']; ?> Ltr</td>
                <td>₹<?php echo $row['total_amount']; ?></td>
                <td>
                    <span class="badge <?php echo ($row['payment_status'] == 'Paid') ? 'bg-success' : 'bg-warning'; ?>">
                        <?php echo $row['payment_status']; ?>
                    </span>
                </td>
                <td>
                    <?php if($row['payment_status'] == 'Pending'): ?>
                        <a href="payments.php?pay_id=<?php echo $row['payment_id']; ?>" class="btn btn-sm btn-success">Mark as Paid</a>
                    <?php else: ?>
                        <button class="btn btn-sm btn-secondary" disabled>Completed</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>