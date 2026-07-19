<?php
// 1. 获取主页传过来的 category_id，如果没有则默认为 1
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;

// 2. 连接数据库
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "web based"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. (可选) 获取当前系列的名称，用来显示在页面标题
$cat_name = "盲盒系列";
$sql_cat = "SELECT name FROM categories WHERE id = $category_id";
$result_cat = $conn->query($sql_cat);
if ($result_cat->num_rows > 0) {
    $cat_row = $result_cat->fetch_assoc();
    $cat_name = $cat_row['name'];
}

// 4. 获取该系列下的所有商品
$sql_products = "SELECT * FROM products WHERE category_id = $category_id";
$result_products = $conn->query($sql_products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cat_name; ?></title>
    <link rel="stylesheet" href="app.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h1 style="color: #D1001F;"><?php echo $cat_name; ?></h1>
        </div>

        <div class="product-container"> 
            <div class="product">
                <?php
                if ($result_products->num_rows > 0) {
                    while($row = $result_products->fetch_assoc()) {
                        echo '<div class="product-card">';
                        
                        // 1. 照片 (200px 宽)
                        echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '" class="photo">';
                        
                        // 2. 信息和按钮的容器 (CSS已限制为 200px 宽)
                        echo '<div class="product-info">';
                        echo '<p style="color: #333; font-weight: bold;">' . $row["name"] . '</p>'; // 名字改成黑色粗体更好看
                        echo '<p class="price" style="margin-bottom: 15px;">RM ' . $row["price"] . '</p>';
                        
                        // 3. 按钮容器 (使用 Flexbox，平均分配剩余空间)
                        echo '<div style="display: flex; gap: 8px; width: 100%;">';
                        
                        // Add to Cart 按钮
                        echo '<button class="add-to-cart-btn" data-id="' . $row["id"] . '" 
                              style="flex: 1; padding: 8px 0; background-color: #111; color: #fff; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; font-size: 12px; transition: 0.3s;">
                              Add to Cart</button>';

                        // Buy Now 按钮
                        echo '<button class="buy-now-btn" data-id="' . $row["id"] . '" 
                              style="flex: 1; padding: 8px 0; background-color: #D1001F; color: #fff; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; font-size: 12px; transition: 0.3s;">
                              Buy Now</button>';
                              
                        echo '</div>'; // 结束按钮容器
                        echo '</div>'; // 结束 product-info
                        echo '</div>'; // 结束 product-card
                    }
                }
                ?>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <p class="copyright">© 2026 Pop Mart. All rights reserved.</p>
    </footer>

    <!-- jQuery 交互功能 -->
    <script>
    $(document).ready(function() {
        // 1. 加入购物车的点击效果 (留在原页)
        $('.add-to-cart-btn').click(function() {
            var productId = $(this).data('id');
            var $btn = $(this);
            
            // 点击后改变按钮样式和文字
            $btn.text('已加入!');
            $btn.css('background-color', '#4CAF50'); // 变成绿色作为成功反馈
            
            // 1.5秒后恢复原状
            setTimeout(function(){
                $btn.text('加入购物车');
                $btn.css('background-color', '#111');
            }, 1500);

            // AJAX 发送到购物车模块 (这里后续你可以自己写 cart.php 逻辑)
            // $.post('add_to_cart.php', { id: productId });
        });

        // 2. 立即购买的点击效果 (直接跳转)
        $('.buy-now-btn').click(function() {
            var productId = $(this).data('id');
            
            // 带着 productId 直接跳转到你的付款或结算页面
            // 如果你的结算页面叫 payment.php，就这样写：
            window.location.href = 'payment.php?product_id=' + productId;
        });
    });
    </script>
</body>
</html>
<?php
// 关闭数据库连接
$conn->close();
?>