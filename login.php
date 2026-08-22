<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Layout</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

<?php
include 'includes/base.php';

// ----------------------------------------------------------------------------

if (is_post()) {
    $email    = req('email');
    $password = req('password');

    // Validate: email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }

    // Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }

    // Login user
    if (!$_err) {
        // TODO
        $stm = $_db->prepare('
            SELECT * FROM users
            WHERE email = ? AND password = SHA1(?)
        ');
        $stm->execute([$email,$password]);
        $u = $stm->fetch();

        if ($u) {
            temp('info', 'Login successfully');
            login($u);
            // TODO
        }
        else {
            $_err['password'] = 'Not matched';
        }
    }
}

// ----------------------------------------------------------------------------

$_title = 'Login';
include 'includes/header.php'; //html_password is to set pw to *******
?>


    <div class="container">
        <h1>Login</h1>

        <form method="post" class="form">
            <div class="user">

                <label for="email">Email</label>
                    <?= html_text('email', 'maxlength="100"') ?>
                     <?= err('email') ?>
            </div>

            <div class="password">
                <label for="password">Password</label>  
                <?= html_password('password', 'maxlength="100"') ?> 
                <?= err('password') ?>
            </div>

            <button type="submit" class="login">Login</button>
        </form>

    </div>

    
</form>




