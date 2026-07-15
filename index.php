<?php
// Homepage entry point. Add server-side PHP here when needed.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Layout</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>

    <header class="main-header">
        <div class="logo">MyWebsite</div>
        <nav class="nav-links">
            <a href="#">Shop</a>
            <a href="#">Cart</a>
            <a href="#">Membership</a>
            <a href="#">About us</a>
            <a href="#">User</a>
        </nav>
    </header>

<main class="content">


<div class="auto-scrolling"></div>

<div class="title">
    <img src='picture/mainT.png' class="title-picture">
</div>


<div class ="product-container"> 
    <div class="product">
        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart1.jpg" alt="product1" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart1.jpg" alt="product2" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart2.jpg" alt="product3" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>
    </div>

    <div class="product">
        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart2.jpg" alt="product4" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart2.jpg" alt="product5" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product1.php" class="card-link"></a>
            <img src="picture/popmart3.jpg" alt="prodcut6" class="photo">
            <div class="product-info">
                <p>智能无线耳机</p>
                <p class="price">¥499.00</p>
            </div>
        </div>
    </div>
</div>
    
</main>


    <footer class="main-footer">
         <p class="copyright">© 2026 Pop Mart. All rights reserved.</p>
</div>
    </footer>

</body>
</html>
