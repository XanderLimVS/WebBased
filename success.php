<?php
// 接收 payment.php 传过来的表单数据
$customer_name = isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : 'User';
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

// 转换一下付款方式的显示名称
$method_display = "";
switch($payment_method) {
    case 'tng': $method_display = "Touch 'n Go eWallet"; break;
    case 'FPX': $method_display = "FPX"; break;
    default: $method_display = "Online Payment";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="app.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; text-align: center; background-color: #f9f9f9;">
    
    <div style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h1 style="color: #4CAF50; font-size: 3rem; margin-bottom: 20px;">✔ Done Payment！</h1>
        <h2>Thanks for buying, <?php echo $customer_name; ?>!</h2>
        <p style="margin-top: 15px; color: #555;">You used <strong><?php echo $method_display; ?></strong> to pay.</p>
        <p style="color: #555;">Your product will be deliver soon！</p>
        
        <a href="index.php" style="display: inline-block; margin-top: 30px; padding: 10px 25px; background: #D1001F; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">返回主页</a>
    </div>

</body>
</html>