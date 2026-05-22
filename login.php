<?php
include 'config.php';

// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['role'])){
    if($_SESSION['role'] == 'admin') header("Location: admin_dashboard.php");
    elseif($_SESSION['role'] == 'farmer') header("Location: farmer_dashboard.php");
    elseif($_SESSION['role'] == 'customer') header("Location: customer_dashboard.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1){
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];

        if($user['role'] == 'admin') header("Location: admin_dashboard.php");
        elseif($user['role'] == 'farmer') header("Location: farmer_dashboard.php");
        elseif($user['role'] == 'customer') header("Location: customer_dashboard.php");
        exit();
    } else {
        $error = "Invalid Login Credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dairy Management Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            /* CORRECTED IMAGE PATH */
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('assets/images/buffelo.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            backdrop-filter: blur(10px);
            max-width: 400px;
            width: 100%;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px;
            font-weight: bold;
        }
        
        h2 {
            color: #333;
            font-weight: 700;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        <h2 class="text-center mb-4">Dairy System</h2>
        <p class="text-center text-muted mb-4">Please enter your credentials</p>

        <?php if($error != ""){ ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
            </div>

            <button class="btn btn-primary w-100 btn-lg shadow-sm" name="login">
                Login
            </button>
        </form>
    </div>
</div>

</body>
</html>