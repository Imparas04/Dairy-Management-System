<?php
include 'header.php';

if($_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

/* ADD FARMER */
if(isset($_POST['add_farmer'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Default Password: 123456
    $password = md5("123456");

    // 1. Insert into users table
    $stmt = $conn->prepare("INSERT INTO users(name, email, password, role) VALUES(?, ?, ?, 'farmer')");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if($stmt->execute()){
        $user_id = $stmt->insert_id;

        // 2. Insert into farmers table
        $stmt2 = $conn->prepare("INSERT INTO farmers(user_id, farmer_name, phone, address, join_date) VALUES(?, ?, ?, ?, CURDATE())");
        $stmt2->bind_param("isss", $user_id, $name, $phone, $address);
        $stmt2->execute();
        echo "<script>alert('Farmer Added! Default Password: 123456');</script>";
    } else {
        echo "<script>alert('Email already exists!');</script>";
    }
}

/* DELETE FARMER */
if(isset($_GET['delete'])){
    $f_id = $_GET['delete'];
    
    // User ID nikalna zaroori hai taaki users table se bhi delete ho sake
    $res = $conn->query("SELECT user_id FROM farmers WHERE farmer_id = $f_id");
    if($row = $res->fetch_assoc()){
        $u_id = $row['user_id'];
        $conn->query("DELETE FROM users WHERE id = $u_id"); // ON DELETE CASCADE will handle farmers table
    }
    header("Location: farmers.php");
}

/* FETCH FARMERS WITH EMAIL */
// JOIN query use kar rahe hain taaki email bhi dikhe
$farmers = $conn->query("SELECT f.*, u.email FROM farmers f JOIN users u ON f.user_id = u.id");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Farmers</h2>
    <span class="badge bg-info text-dark">Default Password for all: 123456</span>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3 shadow-sm">
            <h5>Add New Farmer</h5>
            <form method="POST">
                <label>Full Name</label>
                <input name="name" class="form-control mb-2" placeholder="e.g. Rajesh Kumar" required>
                
                <label>Email (Username)</label>
                <input type="email" name="email" class="form-control mb-2" placeholder="farmer@gmail.com" required>
                
                <label>Phone</label>
                <input name="phone" class="form-control mb-2" placeholder="9876543210">
                
                <label>Address</label>
                <textarea name="address" class="form-control mb-2" rows="2"></textarea>
                
                <button name="add_farmer" class="btn btn-primary w-100 mt-2">Create Account</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card p-3 shadow-sm">
            <h5>Farmer List</h5>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email/Login</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $farmers->fetch_assoc()){ ?>
                    <tr>
                        <td><strong><?php echo $row['farmer_name']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                            <a href="?delete=<?php echo $row['farmer_id']; ?>" 
                               class="btn btn-outline-danger btn-sm" 
                               onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>