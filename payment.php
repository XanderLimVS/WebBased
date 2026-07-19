<?php
session_start();

// 模拟用户已经登录（在真实的作业里，这段代码应该在你的 login.php 里执行，这里为了测试强制赋值）
$_SESSION['user_id'] = 1; 

// 确保拿到了网址传过来的商品 ID 和已登录的用户 ID
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
$qty = isset($_GET['qty']) ? (int)$_GET['qty'] : 1;
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

if ($product_id == 0 || $user_id == 0) {
    die("Error：No product or user found！");
}

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "web ass"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("connect unsuccessful: " . $conn->connect_error);
}
// 抓取商品
$sql_product = "SELECT * FROM products WHERE id = $product_id";
$result_product = $conn->query($sql_product);
$product = $result_product->fetch_assoc();

// 抓取用户
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();

if (!$product || !$user) {
    die("data fail！");
}

$total_price = $product['price'] * $qty;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="app.css">
    <style>
        .checkout-container {
            display: flex;
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .order-summary, .payment-details {
            flex: 1;
        }
        .order-summary {
            border-right: 1px solid #eee;
            padding-right: 40px;
        }
        
        /* 针对只读信息的样式 */
        .info-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            line-height: 1.8;
        }
        .info-box strong {
            color: #555;
            display: inline-block;
            width: 80px;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .pay-btn {
            width: 100%;
            padding: 12px;
            background-color: #D1001F;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .pay-btn:hover {
            background-color: #a00018;
        }
    </style>
</head>
<body>

    <header class="main-header">
        <div class="logo">MyWebsite</div>
        <nav class="nav-links">
            <a href="index.php">Shop</a>
            <a href="#">Cart</a>
            <a href="#">Membership</a>
            <a href="#">About us</a>
            <a href="#">User</a>
        </nav>
    </header>

    <main class="content">
        <div class="title" style="margin-bottom: 2rem;">
            <h1 style="color: #D1001F;">Payment</h1>
        </div>

        <div class="checkout-container">
            <div class="order-summary">
                <h2>Payment Details</h2>
                <div style="text-align: center; margin-top: 20px;">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" style="width: 200px; object-fit: cover; border: 1px solid #eee; padding: 10px;">
                    <h3 style="margin-top: 15px; color: #333;"><?php echo $product['name']; ?></h3>
                    <p style="color: #666; font-size: 1rem; margin-top: 5px;">RM <?php echo $product['price']; ?> × <?php echo $qty; ?>unit</p>
                    <p style="color: red; font-size: 1.2rem; font-weight: bold; margin-top: 5px;">Total: RM <?php echo number_format($total_price, 2); ?></p>
                </div>
            </div>

            <!-- 右侧：读取数据库资料并直接展示 -->
            <div class="payment-details">
                <h2>User Details</h2>
                
                <!-- 只读展示框：从 $user 变量里读取数据 -->
                <div class="info-box">
                    <p><strong>Username:  </strong> <?php echo $user['full_name']; ?></p>
                    <p><strong>Phone Number:  </strong> <?php echo $user['phone']; ?></p>
                    <p><strong>Address:  </strong> <?php echo $user['address']; ?></p>
                </div>

                <!-- 唯一需要用户操作的表单：选择付款方式并提交订单 -->
                <form action="success.php" method="POST">
                    
                    <!-- 隐藏栏位：把 user_id 和 product_id 传给下一页去生成订单 -->
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="total_price" value="<?php echo $product['price']; ?>">

                    <div class="form-group">
                        <label style="display: block; font-weight: bold; margin-bottom: 10px;">Select Payment Method</label>
                        <select name="payment_method" required>
                            <option value="">-- Select --</option>
                            <option value="tng">Touch 'n Go eWallet</option>
                            <option value="FPX">FPX</option>
                        </select>
                    </div>

                    <button type="submit" class="pay-btn">Comfirm Payment RM <?php echo $product['price']; ?></button>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
<?php $conn->close(); ?>