<?php
include("includes/base.php");
include("includes/header.php");
?>
<div id="info">
    <?= temp('info') ?>
</div>

<div class="auto-scrolling"></div>

<div class="title">
    <img src='picture/mainT.png' class="title-picture">
</div>


<div class ="product-container"> 
    <div class="product">
        <div class="product-card">
            <a href="product.php?category_id=1" class="card-link"></a>
            <img src="picture/Kawaii/Kitty Kawaii.png" alt="product1" class="photo">
            <div class="product-info">
                <p>Kawaii Friends Series</p>
                <p class="price">RM49.99</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product.php?category_id=2" class="card-link"></a>
            <img src="picture/Mech/Ice Bear.png" alt="product2" class="photo">
            <div class="product-info">
                <p>Mecha Guardians Series</p>
                <p class="price">RM49.99</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product.php?category_id=3" class="card-link"></a>
            <img src="picture/Dino/Triceratops.png" alt="product3" class="photo">
            <div class="product-info">
                <p>Dino Pals Adventure</p>
                <p class="price">RM49.99</p>
            </div>
        </div>
    </div>

    <div class="product">
        <div class="product-card">
            <a href="product.php?category_id=4" class="card-link"></a>
            <img src="picture/Mythic Beast/Unicorn.png" alt="product4" class="photo">
            <div class="product-info">
                <p>Mythic Beasts Series</p>
                <p class="price">RM49.99</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product.php?category_id=5" class="card-link"></a>
            <img src="picture/Artist/Art.png" alt="product5" class="photo">
            <div class="product-info">
                <p>Artist Editions Series</p>
                <p class="price">RM49.99</p>
            </div>
        </div>

        <div class="product-card">
            <a href="product.php?category_id=6" class="card-link"></a>
            <img src="picture/Galaxy/Astronaut.png" alt="prodcut6" class="photo">
            <div class="product-info">
                <p>Galactic Explorers Series</p>
                <p class="price">RM49.99</p>
            </div>
        </div>
    </div>
</div>
    
<?php
include("includes/footer.php");
?>
