<?php
include 'config.php';

// Check karo ki Order ID mil rahi hai ya nahi
if(!isset($_GET['oid']) || empty($_GET['oid'])) { 
    die("<h3 style='color:red; text-align:center; margin-top:50px;'>Bhai, Order ID missing hai! Wapas jaakar click karo.</h3>"); 
}

$oid = mysqli_real_escape_string($conn, $_GET['oid']);

// Order aur Customer details fetch karo (JOIN query check karo)
$sql = "SELECT o.*, c.customer_name, c.phone, c.address 
        FROM orders o 
        LEFT JOIN customers c ON o.customer_id = c.customer_id 
        WHERE o.order_id = '$oid'";

$order_query = $conn->query($sql);

if ($order_query->num_rows == 0) {
    die("<h3 style='color:red; text-align:center; margin-top:50px;'>Error: Order #$oid database mein nahi mila!</h3>");
}

$order = $order_query->fetch_assoc();

// Items fetch karo
$items = $conn->query("SELECT oi.*, p.product_name 
                      FROM order_items oi 
                      JOIN products p ON oi.product_id = p.product_id 
                      WHERE oi.order_id = '$oid'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $oid; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print { .no-print { display: none; } body { background: white; } }
        .invoice-box { border: 1px solid #ddd; padding: 30px; border-radius: 10px; max-width: 800px; margin: 50px auto; background: #fff; }
        .table th { background-color: #f8f9fa !important; }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-box shadow">
            <div class="row mb-4">
                <div class="col-6 text-start">
                    <h2 class="text-primary fw-bold">DAIRY SHOP</h2>
                    <p class="text-muted mb-0">Shirala, Sangli, Maharashtra</p>
                    <p class="text-muted">Contact: +91 7559120581</p>
                </div>
                <div class="col-6 text-end">
                    <h3 class="fw-bold text-uppercase">Invoice</h3>
                    <p class="mb-0">Order ID: <strong>#<?php echo $oid; ?></strong></p>
                    <p class="mb-0">Date: <?php echo date('d-M-Y', strtotime($order['order_date'])); ?></p>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-12">
                    <h6 class="text-muted text-uppercase small fw-bold">Customer Details:</h6>
                    <h5 class="mb-1"><?php echo htmlspecialchars($order['customer_name'] ?? 'Walk-in Customer'); ?></h5>
                    <p class="mb-0">Phone: <?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?></p>
                    <p>Address: <?php echo htmlspecialchars($order['address'] ?? 'N/A'); ?></p>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grand_total = 0;
                    if($items->num_rows > 0):
                        while($item = $items->fetch_assoc()): 
                            $subtotal = $item['price'] * $item['quantity'];
                            $grand_total += $subtotal;
                    ?>
                    <tr>
                        <td><?php echo $item['product_name']; ?></td>
                        <td class="text-center">₹<?php echo $item['price']; ?></td>
                        <td class="text-center"><?php echo $item['quantity']; ?></td>
                        <td class="text-end">₹<?php echo number_format($subtotal, 2); ?></td>
                    </tr>
                    <?php endwhile; endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="3" class="text-end">Grand Total</th>
                        <th class="text-end text-success fs-5">₹<?php echo number_format($order['total_amount'], 2); ?></th>
                    </tr>
                </tfoot>
            </table>

            <div class="mt-5 text-center">
                <p class="text-muted small italic">This is a computer-generated invoice.</p>
                <div class="no-print mt-3">
                    <button class="btn btn-dark px-4" onclick="window.print()">Print Bill</button>
                    <a href="orders.php" class="btn btn-outline-secondary px-4">Back to Shop</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>