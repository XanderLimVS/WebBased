<?php
include 'includes/base.php';

if (is_post()) {
    $email    = req('email');
    $password = req('password');
    $confirm = req('confirm'); //confirm psswd

    // Validate: email
    if (!$email) {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else if (!is_unique($email, 'user', 'email')) {
        $_err['email'] = 'Duplicated';
    }

    // Validate: password
    if (!$password) {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }

    // Validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $password) {
        $_err['confirm'] = 'Not matched';
    }

    // DB operation
    if (!$_err) {  
        // (2) Insert user (member)
        $stm = $_db->prepare('
            INSERT INTO user (email, password, role)
            VALUES (?, SHA1(?), ?, ?, "Member")
        ');
        $stm->execute([$email, $password]);

        temp('info', 'Record inserted');
        redirect('/login.php');
    }
}

$_title = 'Register';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <h1>Register</h1>

        <form action="login.php">
            <div class="user">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div class="password">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="confirm-password">
                <label>Confirm Password</label>
                <input type="password" name="confirm-password" required>
            </div>

            <button type="submit" class="register">Register</button>
        </form>

        <p>
            Already have an account?
            <a href="login.php">Login</a>
        </p>
    </div>

</body>
</html>
