<?php
include("includes/base.php");
include("includes/header.php");


// 1. Connect to Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web ass";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 2. Get Product ID from URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 3. Fetch Product Details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div style='text-align:center; padding: 50px;'><h2>Product Not Found</h2><a href='index.php'>Back to Home</a></div>";
    include("includes/footer.php");
    exit();

}

$product = $result->fetch_assoc();


?>

<div class="detail-container">
    <!-- Left: Image View -->
    <div class="detail-media">
        <img src="../<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
    </div>

    <!-- Right: Product Information & Controls -->
    <div class="detail-info">
        <h1 class="detail-title"><?php echo $product['name']; ?></h1>
        
        <div class="detail-price-box">
            <span class="detail-price">RM <?php echo number_format($product['price'], 2); ?></span>
        </div>

        <p><strong>Stock Available:</strong> <?php echo $product['stock']; ?> items</p>

        <!-- Quantity Picker -->
        <div class="qty-selector">
            <label><strong>Quantity:</strong></label>
            <button type="button" class="qty-btn" id="qty-minus">-</button>
            <input type="number" id="detail-qty" class="qty-input" value="1" min="1" max="<?php echo $product['stock']; ?>" readonly>
            <button type="button" class="qty-btn" id="qty-plus">+</button>
        </div>

        <!-- Action Buttons -->
        <div class="btn-container">
            <button type="button" class="add-btn" id="add-cart-btn">Add To Cart</button>
            <button type="button" class="buy-btn" onclick="window.location.href='cart.php'">Go to Cart</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Quantity Adjustment
$('#qty-plus').click(function() {
    var input = $('#detail-qty');
    var val = parseInt(input.val());
    var max = parseInt(input.attr('max'));
    if (val < max) input.val(val + 1);
});

$('#qty-minus').click(function() {
    var input = $('#detail-qty');
    var val = parseInt(input.val());
    if (val > 1) input.val(val - 1);
});

// Add to Cart AJAX (Points directly to cartitem.php backend)
$('#add-cart-btn').click(function() {
    var productId = <?php echo $product['id']; ?>;
    var qty = $('#detail-qty').val();

    $.ajax({
        url: 'cartitem.php',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: qty
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                alert("Successfully added to cart!");
            } else {
                alert(response.message || "Error adding to cart.");
            }
        },
        error: function() {
            alert('Error processing request.');
        }
    });
});
</script>

<?php
include("includes/footer.php");
$conn->close();
?>