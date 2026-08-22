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
            
        <?php if ($_user): ?>   
            <a href="index.php">Shop</a>
            <a href="cart.php">Cart</a>
            <a href="userprofile/profile.php">User</a> 
            <a href="logout.php">Logout</a>

            <div class="user-status">
                    <?= $_user->username ?><br>
                    <?= $_user->user_type?>
                
            </div>

        <?php else: ?>
            <a href="index.php">Shop</a>
            <a href="userprofile/profile.php">User</a> 
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            

            <div class="user-status">           
                    Guest
            </div>
            
         <?php endif ?>
            
       
        </nav>
    </header>

<main class="content">