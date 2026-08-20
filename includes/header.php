<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Layout</title>
    <link rel="stylesheet" href="CSS/app.css">
</head>
<body>


    <header class="main-header">
        <div class="logo">MyWebsite</div>
        <nav class="nav-links">
            <a href="index.php">Shop</a>
            <a href="cart.php">Cart</a>
            <a href="userprofile/profile.php">User</a> 
            <a href="login.php">Login</a>
            <a href="logout.php">logout</a>
            <div class="user-status">
        <?php if ($_user): ?>
            <?= $_user->name ?><br>
            <?= $_user->role ?>
        <?php else: ?>
            Guest
        <?php endif ?>
    </div>
            
            
            
       
        </nav>
    </header>

<main class="content">