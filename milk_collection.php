<?php
include 'header.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* 1. FARMERS LIST - Corrected column name to farmer_name */
$farmers = $conn->query("SELECT farmer_id, farmer_name FROM farmers");

/* 2. ADD MILK ENTRY */
if(isset($_POST['add'])){
    $date = $_POST['date'];
    $farmer = $_POST['farmer'];
    $type = $_POST['milk_type'];
    $qty = $_POST['quantity'];
    $fat = $_POST['fat'];

    /* GET RATE FROM RATE CHART 
       Note: Aapki table structure ke hisaab se logic adjust kiya hai */
    $stmt = $conn->prepare("SELECT rate_per_liter FROM rate_chart WHERE milk_type=? AND fat_percent <= ? ORDER BY fat_percent DESC LIMIT 1");
    $stmt->bind_param("sd", $type, $fat);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    // Agar rate chart mein data nahi hai toh default 40 rakh dete hain error se bachne ke liye
    $rate = ($row) ? $row['rate_per_liter'] : 40.00;

    $total = $qty * $rate;

    /* INSERT RECORD */
    $stmt = $conn->prepare("INSERT INTO milk_collection (date, farmer_id, milk_type, quantity, fat_percent, rate_per_liter, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisdddd", $date, $farmer, $type, $qty, $fat, $rate, $total);
    
    if($stmt->execute()){
        echo "<script>alert('Entry Added Successfully!'); window.location='milk_collection.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

/* 3. DISPLAY COLLECTION - Corrected Join for farmer_name */
$records = $conn->query("SELECT m.*, f.farmer_name FROM milk_collection m JOIN farmers f ON m.farmer_id = f.farmer_id ORDER BY m.date DESC");
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Milk Collection</h2>
        <span class="text-muted">Today: <?php echo date('d-M-Y'); ?></span>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5 class="card-title">New Entry</h5>
                <hr>
                <form method="POST">
                    <label>Collection Date</label>
                    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control mb-2" required>

                    <label>Select Farmer</label>
                    <select name="farmer" class="form-control mb-2" required>
                        <option value="">-- Select Farmer --</option>
                        <?php while($f = $farmers->fetch_assoc()){ ?>
                            <option value="<?php echo $f['farmer_id']; ?>"><?php echo $f['farmer_name']; ?></option>
                        <?php } ?>
                    </select>

                    <label>Milk Type</label>
                    <select name="milk_type" class="form-control mb-2">
                        <option value="cow">Cow</option>
                        <option value="buffalo">Buffalo</option>
                    </select>

                    <label>Quantity (Liters)</label>
                    <input type="number" step="0.01" name="quantity" class="form-control mb-2" placeholder="0.00" required>

                    <label>FAT %</label>
                    <input type="number" step="0.1" name="fat" class="form-control mb-2" placeholder="0.0" required>

                    <button name="add" class="btn btn-primary w-100 mt-2">Add Entry</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5>Recent Collections</h5>
                <div class="table-responsive">
                    <table class="table table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Farmer</th>
                                <th>Type</th>
                                <th>Qty</th>
                                <th>FAT</th>
                                <th>Rate</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($records->num_rows > 0): ?>
                                <?php while($r = $records->fetch_assoc()){ ?>
                                <tr>
                                    <td><?php echo date('d/m/y', strtotime($r['date'])); ?></td>
                                    <td><strong><?php echo $r['farmer_name']; ?></strong></td>
                                    <td><?php echo ucfirst($r['milk_type']); ?></td>
                                    <td><?php echo $r['quantity']; ?> L</td>
                                    <td><?php echo $r['fat_percent']; ?>%</td>
                                    <td>₹<?php echo $r['rate_per_liter']; ?></td>
                                    <td><strong>₹<?php echo $r['total_amount']; ?></strong></td>
                                </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center">No records found</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>