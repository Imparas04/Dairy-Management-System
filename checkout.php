<?php
include 'config.php';
include 'header.php';

// Check if Order ID and Amount are provided
if(!isset($_GET['oid']) || !isset($_GET['amt'])) { 
    header("Location: orders.php"); 
    exit(); 
}

$oid = $_GET['oid'];
$amt = $_GET['amt'];
$upi_id = "paraschoudhary8411@okhdfcbank"; 

// QR Code API setup
$upi_url = "upi://pay?pa=$upi_id&pn=DairyShop&am=$amt&cu=INR&tn=Order_$oid";
$qr_api = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" . urlencode($upi_url);
?>

<div class="container mt-5 text-center">
    <div class="card shadow p-4 mx-auto" style="max-width: 450px; border-radius: 20px; border:none;">
        <h3 class="fw-bold mb-4">Complete Payment</h3>
        <div class="alert alert-success">Order #<?php echo $oid; ?> | Total: <b>₹<?php echo $amt; ?></b></div>

        <div class="row g-3">
            <div class="col-12">
                <button class="btn btn-outline-dark btn-lg w-100 p-3 fw-bold" onclick="payCash()">
                    💵 Cash on Delivery
                </button>
            </div>
            
            <div class="col-12 mt-4">
                <h6 class="fw-bold">Pay via UPI QR</h6>
                <img src="<?php echo $qr_api; ?>" class="img-fluid border p-2 mb-3" style="width: 200px; border-radius:10px;">
                <p class="small text-muted">Scan with any UPI App (GPay/PhonePe)</p>
                <button class="btn btn-success btn-lg w-100 fw-bold mb-3" onclick="payDone()">
                    ✅ I Have Paid Online
                </button>
            </div>
        </div>

        <hr>
        <div class="mt-2">
            <a href="generate_bill.php?oid=<?php echo $oid; ?>" target="_blank" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                📄 View & Print Bill
            </a>
        </div>
        
        <a href="orders.php" class="d-block mt-4 text-muted text-decoration-none small">← Back to Shop</a>
    </div>
</div>

<script>
function payCash() {
    alert("Order #<?php echo $oid; ?> Placed via Cash! Please pay at delivery.");
    window.location.href = 'orders.php';
}
function payDone() {
    alert("Thanks for the payment! Admin will verify Order #<?php echo $oid; ?> soon.");
    window.location.href = 'orders.php';
}
</script>

<?php include 'footer.php'; ?>