<?php
include("includes/base.php");

// --- 1. HANDLE CART UPDATE & REMOVE AJAX REQUESTS ---
// This handles the +, -, and Remove buttons directly without needing extra files.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    $conn = new mysqli("localhost", "root", "", "web ass");
    
    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
        exit();
    }

    $cart_item_id = isset($_POST['cart_item_id']) ? (int)$_POST['cart_item_id'] : 0;

    if ($_POST['action'] === 'update_qty') {
        $quantity = (int)$_POST['quantity'];
        $stmt = $conn->prepare("UPDATE cart_item SET Quantity = ? WHERE Cart_Item_ID = ?");
        $stmt->bind_param("ii", $quantity, $cart_item_id);
        $stmt->execute();
    } elseif ($_POST['action'] === 'remove_item') {
        $stmt = $conn->prepare("DELETE FROM cart_item WHERE Cart_Item_ID = ?");
        $stmt->bind_param("i", $cart_item_id);
        $stmt->execute();
    }

    echo json_encode(['status' => 'success']);
    $conn->close();
    exit(); // Stop executing the rest of the page for AJAX calls
}

// --- 2. REGULAR PAGE LOAD: DISPLAY CART ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web ass";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 当前用户 ID
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1;

// 获取这个用户购物车里的商品 (Added cart_item.Product_ID for the detail links)
$sql = "SELECT cart_item.Cart_Item_ID,
               cart_item.Product_ID,
               cart_item.Quantity,
               products.name,
               products.price,
               products.image_url,
               products.stock
        FROM cart_item
        JOIN products
        ON cart_item.Product_ID = products.id
        WHERE cart_item.User_ID = $user_id";

$result = $conn->query($sql);

// 计算购物车总价
$total = 0;

include("includes/header.php");
?>

<link rel="stylesheet" href="/WebBased/CSS/cart.css">
<div class="title" style="margin-bottom: 2rem;">
    <h1 style="color: #D1001F;">Pop Cart</h1>
</div>

<div class="product-container">

    <!-- Empty Cart Message -->
    <?php
    if ($result->num_rows == 0) {
        echo '<p class="empty-cart">Your cart is empty.</p>';
    }
    ?>

    <div class="product">

        <!-- ADD MORE -->
        <a href="index.php" class="product-card add-more-card"></a>

        <?php
        // 显示购物车商品
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                // 商品小计
                $subtotal = $row["price"] * $row["Quantity"];

                // 加入总价
                $total = $total + $subtotal;

                echo '<div class="product-card">';

                // Clickable Image -> goes to product_detail.php
                echo '<a href="productdetails.php?id=' . $row["Product_ID"] . '">';
                echo '<img src="../' . $row["image_url"] . '"
                           alt="' . $row["name"] . '"
                           class="photo">';
                echo '</a>';

                echo '<div class="product-info">';

                // Clickable Title -> goes to product_detail.php
                echo '<p><a href="productdetails.php?id=' . $row["Product_ID"] . '" style="text-decoration:none; color:inherit;"><strong>' . $row["name"] . '</strong></a></p>';

                // 商品价格
                echo '<p class="price">
                        RM ' . number_format($row["price"], 2) . '
                      </p>';

                // 数量
                echo '<div class="qty-container">';

                echo '<button type="button"
                              class="qty-btn qty-minus"
                              data-id="' . $row["Cart_Item_ID"] . '">
                        -
                      </button>';

                echo '<input type="number"
                              value="' . $row["Quantity"] . '"
                              min="1"
                              max="' . $row["stock"] . '"
                              class="qty-input"
                              id="qty-' . $row["Cart_Item_ID"] . '"
                              readonly>';

                echo '<button type="button"
                              class="qty-btn qty-plus"
                              data-id="' . $row["Cart_Item_ID"] . '">
                        +
                      </button>';

                echo '</div>';

                // Remove button
                echo '<button class="remove-btn"
                              data-id="' . $row["Cart_Item_ID"] . '">
                        Remove
                      </button>';

                echo '</div>'; // End product-info

                echo '</div>'; // End product-card
            }
        }
        ?>

    </div>

    <!-- Cart Total -->
    <div class="cart-total">
        <h2>
            Total: RM <?php echo number_format($total, 2); ?>
        </h2>

        <button class="buy-now-btn" onclick="window.location.href='payment.php'">
            Checkout
        </button>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

// Helper function to update backend DB when quantity changes
function updateCartQuantity(cartItemId, newQty) {
    $.ajax({
        url: 'cart.php',
        type: 'POST',
        data: {
            action: 'update_qty',
            cart_item_id: cartItemId,
            quantity: newQty
        },
        success: function() {
            location.reload(); // Refresh page to recalculate total
        }
    });
}

// Quantity +
$('.qty-plus').click(function() {
    var id = $(this).data('id');
    var input = $('#qty-' + id);
    var current = parseInt(input.val());
    var max = parseInt(input.attr('max'));

    if (current < max) {
        var updated = current + 1;
        input.val(updated);
        updateCartQuantity(id, updated);
    } else {
        alert("Maximum stock reached!");
    }
});

// Quantity -
$('.qty-minus').click(function() {
    var id = $(this).data('id');
    var input = $('#qty-' + id);
    var current = parseInt(input.val());

    if (current > 1) {
        var updated = current - 1;
        input.val(updated);
        updateCartQuantity(id, updated);
    }
});

// Remove button
$('.remove-btn').click(function() {
    var id = $(this).data('id');

    if (confirm("Are you sure you want to remove this item?")) {
        $.ajax({
            url: 'cart.php',
            type: 'POST',
            data: {
                action: 'remove_item',
                cart_item_id: id
            },
            success: function() {
                location.reload();
            }
        });
    }
});

</script>

<?php
include("includes/footer.php");
$conn->close();
?>