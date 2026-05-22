<?php
include 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$u_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// --- ORDER LOGIC ---
if (isset($_POST['place_order'])) {
    
    // 1. SAHI CUSTOMER ID NIKALNA (Constraint Fix)
    if ($role == 'admin') {
        $cust_id = $_POST['customer_id'];
    } else {
        // User ID (Login table) se Customer ID (Customers table) dhoondho
        $get_cust = $conn->query("SELECT customer_id FROM customers WHERE user_id = '$u_id'");
        if ($get_cust->num_rows > 0) {
            $c_data = $get_cust->fetch_assoc();
            $cust_id = $c_data['customer_id'];
        } else {
            // Agar customer table mein entry nahi hai toh temporary user_id try karega (lekin ye fail ho sakta hai agar FK set hai)
            die("Error: Aapka profile 'customers' table mein nahi mila. Pehle registration check karein.");
        }
    }

    $prod_id = $_POST['product_id'];
    $qty = $_POST['quantity'];
    
    // Product details
    $p_check = $conn->query("SELECT price, stock FROM products WHERE product_id = '$prod_id'");
    $p_data = $p_check->fetch_assoc();
    
    if ($p_data && $p_data['stock'] >= $qty) {
        $price = $p_data['price'];
        $total = $qty * $price;

        // Order Insert
        $sql_order = "INSERT INTO orders (customer_id, total_amount) VALUES ('$cust_id', '$total')";
        
        if ($conn->query($sql_order)) {
            $order_id = $conn->insert_id;
            
            // Item Insert
            $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ('$order_id', '$prod_id', '$qty', '$price')");
            
            // Stock Update
            $conn->query("UPDATE products SET stock = stock - '$qty' WHERE product_id = '$prod_id'");
            
            // Smooth JS Redirect
            echo "<script>window.location.href='checkout.php?oid=$order_id&amt=$total';</script>";
            exit();
        } else {
            // Agar abhi bhi Foreign Key error aaye toh iska matlab DB mein data mismatch hai
            die("Database Error: " . $conn->error);
        }
    } else {
        echo "<script>alert('Error: Stock issue!'); window.location.href='orders.php';</script>";
        exit();
    }
}

include 'header.php';
?>

<style>
    .product-card {
        background-size: cover; background-position: center; min-height: 380px;
        position: relative; border-radius: 15px; overflow: hidden; border: none;
        transition: transform 0.3s ease; margin-bottom: 25px;
    }
    .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.4); }
    .card-overlay {
        background: rgba(255, 255, 255, 0.95); position: absolute;
        bottom: 0; left: 0; right: 0; padding: 20px; backdrop-filter: blur(8px); text-align: center;
    }
    .custom-input-group { display: flex; justify-content: center; gap: 5px; width: 100%; }
    .custom-input-group input { max-width: 80px; text-align: center; }
</style>

<div class="container mt-4">
    <?php if ($role == 'admin'): ?>
        <h2 class="mb-4">Admin: Milk & Product Sales</h2>
        <div class="card p-4 mb-4 shadow-sm">
            <form method="POST" action="orders.php" class="row g-2">
                <div class="col-md-3">
                    <select name="customer_id" class="form-control" required>
                        <option value="">-- Customer --</option>
                        <?php 
                        $clist = $conn->query("SELECT * FROM customers");
                        while($c = $clist->fetch_assoc()) echo "<option value='".$c['customer_id']."'>".$c['customer_name']."</option>";
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="product_id" class="form-control" required>
                        <option value="">-- Product --</option>
                        <?php 
                        $plist = $conn->query("SELECT * FROM products");
                        while($p = $plist->fetch_assoc()) echo "<option value='".$p['product_id']."'>".$p['product_name']." - ₹".$p['price']."</option>";
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="quantity" class="form-control" placeholder="Qty" min="1" required>
                </div>
                <div class="col-md-3">
                    <button type="submit" name="place_order" class="btn btn-primary w-100">Confirm Order</button>
                </div>
            </form>
        </div>
    <?php else: ?>
        <h2 class="mb-4">Shop Dairy & Fresh Milk</h2>
        <div class="row">
            <?php
            $products = $conn->query("SELECT * FROM products WHERE stock > 0");
            while($p = $products->fetch_assoc()):
                $img_path = "assets/images/" . (!empty($p['image']) ? $p['image'] : 'default_dairy.jpg');
            ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card product-card shadow-sm" style="background-image: url('<?php echo $img_path; ?>');">
                    <div class="card-overlay">
                        <h5 class="fw-bold mb-1"><?php echo $p['product_name']; ?></h5>
                        <p class="text-success fw-bold">₹<?php echo $p['price']; ?></p>
                        <form method="POST" action="orders.php">
                            <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
                            <div class="custom-input-group">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $p['stock']; ?>" class="form-control">
                                <button type="submit" name="place_order" class="btn btn-success shadow-sm">Buy Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>