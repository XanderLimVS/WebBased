<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Layout</title>
    <link rel="stylesheet" href="../CSS/app.css">
</head>
<body>


    <header class="main-header">
        <div class="logo">MyWebsite</div>
        <nav class="nav-links">

            <a href="admin/additem.php">Product</a>
            <a href="#">Member</a>
            <a href="../logout.php">Logout</a>

            <div class="user-status">
                    <?= $_user->username ?><br>
                    <?= $_user->user_type?>
                
            </div>

       
        </nav>
    </header>

<main class="content">