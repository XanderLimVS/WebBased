<?php
// 1. 获取主页传过来的 category_id，如果没有则默认为 1
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 1;

// 2. 连接数据库
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "web ass"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. (可选) 获取当前系列的名称，用来显示在页面标题
$cat_name = "盲盒系列";
$sql_cat = "SELECT name FROM categories WHERE id = $category_id";
$result_cat = $conn->query($sql_cat);
if ($result_cat && $result_cat->num_rows > 0) {
    $cat_row = $result_cat->fetch_assoc();
    $cat_name = $cat_row['name'];
}

// 4. 获取该系列下的所有商品
$sql_products = "SELECT * FROM products WHERE category_id = $category_id";
$result_products = $conn->query($sql_products);

include("includes/header.php");
include("includes/base.php");
?>

<div class="title" style="margin-bottom: 2rem;">
    <h1 style="color: #D1001F;"><?php echo $cat_name; ?></h1>
</div>

<div class="product-container"> 
    <div class="product">
        <?php
        if ($result_products && $result_products->num_rows > 0) {
            while($row = $result_products->fetch_assoc()) {
                echo '<div class="product-card">';
                
                // 1. 照片 (点击跳转到 product_detail.php)
                echo '<a href="product_detail.php?id=' . $row["id"] . '">';
                echo '<img src="' . $row["image_url"] . '" alt="' . $row["name"] . '" class="photo">';
                echo '</a>';
                
                // 2. 信息和按钮的容器 (CSS已限制为 200px 宽)
                echo '<div class="product-info">';
                echo '<p><a href="product_detail.php?id=' . $row["id"] . '" style="color: #333; font-weight: bold; text-decoration: none;">' . $row["name"] . '</a></p>'; 
                echo '<p class="price" style="margin-bottom: 15px;">RM ' . $row["price"] . '</p>';
                
                echo '<div class="qty-container">';
                echo '<button type="button" class="qty-btn qty-minus" data-id="' . $row["id"] . '">-</button>';
                echo '<input type="number" class="qty-input" id="qty-' . $row["id"] . '" value="1" min="1" max="' . $row["stock"] . '" readonly>';
                echo '<button type="button" class="qty-btn qty-plus" data-id="' . $row["id"] . '">+</button>';
                echo '</div>';
                
                // 3. 按钮容器 (使用 Flexbox，平均分配剩余空间)
                echo '<div style="display: flex; gap: 8px; width: 100%;">';
                echo '<button class="add-to-cart-btn" data-id="' . $row["id"] . '" style="flex: 1; padding: 8px 0; background-color: #111; color: #fff; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; font-size: 12px; transition: 0.3s;">Add to Cart</button>';
                echo '<button class="buy-now-btn" data-id="' . $row["id"] . '" style="flex: 1; padding: 8px 0; background-color: #D1001F; color: #fff; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; font-size: 12px; transition: 0.3s;">Buy Now</button>';
                echo '</div>'; 
                
                echo '</div>'; // 结束 product-info
                echo '</div>'; // 结束 product-card
            }
        }
        ?>
    </div>
</div>



<!-- 图片放大模态框 (Modal) 容器 -->
<div id="imageModal" class="modal">
    <span class="close-modal">&times;</span>
    <img class="modal-content" id="enlargedImg">
</div>

<!-- jQuery 交互功能 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // 1. 数量加减逻辑
    $('.qty-plus').click(function() {
        var id = $(this).data('id');
        var $input = $('#qty-' + id);
        var currentVal = parseInt($input.val());
        var maxVal = parseInt($input.attr('max')); // 获取库存上限
        
        if (currentVal < maxVal) {
            $input.val(currentVal + 1);
        } else {
            alert("on MAXIMUM stock！");
        }
    });

    $('.qty-minus').click(function() {
        var id = $(this).data('id');
        var $input = $('#qty-' + id);
        var currentVal = parseInt($input.val());
        
        if (currentVal > 1) {
            $input.val(currentVal - 1);
        }
    });

    // 2. 加入购物车的点击效果 (AJAX 写入 cartitem.php)
    $('.add-to-cart-btn').click(function() {
        var productId = $(this).data('id');
        var qty = $('#qty-' + productId).val(); // 获取当前选中的数量
        var $btn = $(this);
        
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
                    $btn.text('Added!');
                    $btn.css('background-color', '#4CAF50'); 
                    
                    setTimeout(function(){
                        $btn.text('Add to Cart');
                        $btn.css('background-color', '#111');
                    }, 1500);
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error adding item to cart.');
            }
        });
    });

    // 3. 立即购买的跳转逻辑 (带上数量)
    $('.buy-now-btn').click(function() {
        var productId = $(this).data('id');
        var qty = $('#qty-' + productId).val(); // 获取当前选中的数量
        
        // 跳转时，URL 变成了 payment.php?product_id=X&qty=Y
        window.location.href = 'payment.php?product_id=' + productId + '&qty=' + qty;
    });

    // 4. 放大图片的逻辑
    $('.photo').click(function(e) {
        e.preventDefault();
        var imgSrc = $(this).attr('src'); 
        $('#enlargedImg').attr('src', imgSrc); 
        $('#imageModal').fadeIn(300); 
    });

    $('.close-modal, #imageModal').click(function(e) {
        if (e.target !== $('#enlargedImg')[0]) {
            $('#imageModal').fadeOut(300); 
        }
    });
});
</script>

<?php
// 关闭数据库连接
include("includes/footer.php");
$conn->close();
?>