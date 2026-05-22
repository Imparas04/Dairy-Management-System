<?php
include 'config.php';
include 'header.php';

// Update Stock or Price
if (isset($_POST['update_product'])) {
    $p_id = $_POST['product_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $conn->query("UPDATE products SET price = '$price', stock = '$stock' WHERE product_id = $p_id");
    $msg = "Product updated successfully!";
}
?>

<div class="container">
    <h2>Inventory Management</h2>
    <?php if(isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Product Name</th>
                <th>Price (per unit)</th>
                <th>Current Stock</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("SELECT * FROM products");
            while($row = $res->fetch_assoc()):
            ?>
            <form method="POST">
                <tr>
                    <td><strong><?php echo $row['product_name']; ?></strong></td>
                    <td><input type="number" name="price" value="<?php echo $row['price']; ?>" class="form-control"></td>
                    <td><input type="number" name="stock" value="<?php echo $row['stock']; ?>" class="form-control"></td>
                    <td>
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <button type="submit" name="update_product" class="btn btn-primary btn-sm">Save Changes</button>
                    </td>
                </tr>
            </form>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>