<?php
session_start();
header('Content-Type: application/json');

// 1. Connect to database
$conn = new mysqli("localhost", "root", "", "web ass");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit();
}

// 2. Get POST data
$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 1;
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id <= 0 || $quantity <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid product or quantity.']);
    $conn->close();
    exit();
}

// 3. Check if item already exists in cart for this user
$check_sql = "SELECT Cart_Item_ID, Quantity FROM cart_item WHERE User_ID = ? AND Product_ID = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Item exists -> Update quantity
    $row = $result->fetch_assoc();
    $new_qty = $row['Quantity'] + $quantity;
    
    $update_sql = "UPDATE cart_item SET Quantity = ? WHERE Cart_Item_ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $new_qty, $row['Cart_Item_ID']);
    $update_stmt->execute();
} else {
    // New item -> Insert into cart
    $insert_sql = "INSERT INTO cart_item (User_ID, Product_ID, Quantity) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $user_id, $product_id, $quantity);
    $insert_stmt->execute();
}

echo json_encode(['status' => 'success']);
$conn->close();
exit();
?>