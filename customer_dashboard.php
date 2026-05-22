<?php
include 'header.php';

if($_SESSION['role'] != 'customer'){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* 1. GET CUSTOMER ID */
$stmt = $conn->prepare("SELECT customer_id FROM customers WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$customer_id = $row['customer_id'];

/* 2. ORDER FUNCTION (Reusable) */
function placeOrder($conn, $cust_id, $prod_id, $qty, $total) {
    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)");
    $stmt->bind_param("id", $cust_id, $total);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // Insert into order_items table
    $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $unit_price = $total / $qty;
    $stmt2->bind_param("iiid", $order_id, $prod_id, $qty, $unit_price);
    $stmt2->execute();

    // Update Stock (if it's a product, not fresh milk)
    if($prod_id > 0) {
        $conn->query("UPDATE products SET stock = stock - $qty WHERE product_id = $prod_id");
    }
}

/* 3. BUY FRESH MILK */
if(isset($_POST['buy_milk'])){
    $type = $_POST['milk_type'];
    $qty = $_POST['quantity'];
    $price = ($type == "cow") ? 50 : 65;
    $total = $price * $qty;
    
    placeOrder($conn, $customer_id, 0, $qty, $total); // 0 means Fresh Milk
    echo "<script>alert('Milk Order Placed!');</script>";
}

/* 4. BUY DAIRY PRODUCTS */
if(isset($_POST['buy_product'])){
    $p_id = $_POST['product'];
    $qty = $_POST['qty'];

    $res = $conn->query("SELECT price, stock FROM products WHERE product_id = $p_id");
    $p = $res->fetch_assoc();

    if($p['stock'] >= $qty) {
        $total = $p['price'] * $qty;
        placeOrder($conn, $customer_id, $p_id, $qty, $total);
        echo "<script>alert('Product Ordered Successfully!');</script>";
    } else {
        echo "<script>alert('Sorry, Not enough stock!');</script>";
    }
}

/* 5. DATA FOR DISPLAY */
$products = $conn->query("SELECT * FROM products WHERE stock > 0");
$order_history = $conn->query("
    SELECT o.order_date, o.total_amount, oi.quantity, oi.product_id, p.product_name 
    FROM orders o 
    JOIN order_items oi ON o.order_id = oi.order_id 
    LEFT JOIN products p ON oi.product_id = p.product_id 
    WHERE o.customer_id = $customer_id 
    ORDER BY o.order_date DESC
");
$total_purchase = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE customer_id = $customer_id")->fetch_assoc();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-3 mb-4 text-center">
                <h6>Total Purchase</h6>
                <h2>₹ <?php echo number_format($total_purchase['total'] ?? 0, 2); ?></h2>
            </div>

             

            <div class="card p-3 shadow-sm">
                <h5>Buy Dairy Products</h5>
                <form method="POST">
                    <select name="product" class="form-control mb-2">
                        <?php 
                        $products_list = $conn->query("SELECT * FROM products WHERE stock > 0");
                        while($p = $products_list->fetch_assoc()){ 
                        ?>
                            <option value="<?php echo $p['product_id']; ?>">
                                <?php echo $p['product_name']; ?> - ₹<?php echo $p['price']; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <input type="number" name="qty" class="form-control mb-2" placeholder="Quantity" required>
                    <button name="buy_product" class="btn btn-success w-100">Buy Product</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h4>Order History</h4>
                <table class="table table-hover mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($o = $order_history->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo date('d-M-y H:i', strtotime($o['order_date'])); ?></td>
                            <td><?php echo ($o['product_id'] == 0) ? "Fresh Milk" : $o['product_name']; ?></td>
                            <td><?php echo $o['quantity']; ?></td>
                            <td>₹ <?php echo $o['total_amount']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>