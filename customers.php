<?php
include 'header.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* ADD CUSTOMER */
if(isset($_POST['add_customer'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = md5("123456"); // Default Password

    $stmt = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES(?, ?, ?, 'customer')");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if($stmt->execute()){
        $user_id = $stmt->insert_id;
        $stmt2 = $conn->prepare("INSERT INTO customers(user_id, customer_name, phone, address) VALUES(?, ?, ?, ?)");
        $stmt2->bind_param("isss", $user_id, $name, $phone, $address);
        $stmt2->execute();
        echo "<script>alert('Customer Created! Default Pass: 123456');</script>";
    }
}

/* DELETE CUSTOMER (Proper way) */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $res = $conn->query("SELECT user_id FROM customers WHERE customer_id=$id");
    if($row = $res->fetch_assoc()){
        $u_id = $row['user_id'];
        $conn->query("DELETE FROM users WHERE id=$u_id");
    }
    header("Location: customers.php");
}

$customers = $conn->query("SELECT * FROM customers");
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5>Add New Customer</h5>
                <form method="POST">
                    <input name="name" class="form-control mb-2" placeholder="Full Name" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email (Username)" required>
                    <input name="phone" class="form-control mb-2" placeholder="Phone">
                    <textarea name="address" class="form-control mb-2" placeholder="Address"></textarea>
                    <button name="add_customer" class="btn btn-primary w-100">Add Customer</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5>Registered Customers</h5>
                <table class="table">
                    <thead>
                        <tr><th>Name</th><th>Phone</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php while($row = $customers->fetch_assoc()){ ?>
                        <tr>
                            <td><?php echo $row['customer_name']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><a href="?delete=<?php echo $row['customer_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete customer?')">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>