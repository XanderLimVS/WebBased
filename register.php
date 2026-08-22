<?php  
include 'includes/base.php';  
  
// ----------------------------------------------------------------------------  
//(username, full_name, email, password, phone, address, user_type 
if (is_post()) {  
    $username = req('username');  
    $full_name = req('fullname'); 
    $email    = req('email');  
    $password = req('password');  
    $confirm  = req('confirm');  
    $address = req('address'); 
    $phone = req('phone'); 
 
 
    //username
    if(!$username){ 
        $_err['username'] = 'Required'; 
    }  
    else if (strlen($username) > 25) {  
        $_err['username'] = 'Maximum 25 characters';  
    }  
    else if (!is_unique($username, 'users', 'username')) {  
        $_err['username'] = 'Duplicated';  
    }  
 
    //full name
    if (!$full_name) {  
        $_err['fullname'] = 'Required';  
    }  
    else if (strlen($full_name) > 100) {  
        $_err['fullname'] = 'Maximum 100 characters';  
    }  
 
    //email 
    if (!$email) {  
        $_err['email'] = 'Required';  
    }  
    else if (strlen($email) > 100) {  
        $_err['email'] = 'Maximum 100 characters';  
    }  
    else if (!is_email($email)) {  
        $_err['email'] = 'Invalid email';  
    }  
    else if (!is_unique($email, 'users', 'email')) {  
        $_err['email'] = 'Duplicated';  
    }  
 
    //password 
    if (!$password) {  
        $_err['password'] = 'Required';  
    }  
    else if (strlen($password) < 5 || strlen($password) > 100) {  
        $_err['password'] = 'Between 5-100 characters';  
    }  
  
    //confirm password
    if (!$confirm) {  
        $_err['confirm'] = 'Required';  
    }  
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {  
        $_err['confirm'] = 'Between 5-100 characters';  
    }  
    else if ($confirm != $password) {  
        $_err['confirm'] = 'Not matched';  
    }  

    //phone
    if (!$phone) {  
        $_err['phone'] = 'Required';  
    }  
    else if (strlen($phone) > 20) {  
        $_err['phone'] = 'Maximum 20 characters';  
    }  

    //address
    if (!$address) {  
        $_err['address'] = 'Required';  
    }  
    else if (strlen($address) > 255) {  
        $_err['address'] = 'Maximum 255 characters';  
    }  
     
    if (!$_err) {  
 
        // Values that are not entered by the user 
        $user_type = 'user'; 
        $user_status = 'active'; 
        $conins = '100'; 
 
        $stm = $_db->prepare('  
            INSERT INTO users  
            (username, full_name, email, password, phone, address, user_type)  
            VALUES (?, ?, ?, SHA1(?), ?, ?, ?)  
        ');  
 
        $stm->execute([ 
            $username,  
            $full_name,  
            $email,  
            $password,  
            $phone,  
            $address,  
            $user_type 
        ]);  
 
        temp('info', 'Succcess Register');  
        redirect('login.php');  
    }  
}  
  
// ----------------------------------------------------------------------------  
  
$_title = 'User | Register Member';  
include 'includes/header.php';  
?>  
  
<form method="post" class="form">  

    <label for="username">Username</label>  
    <?= html_text('username', 'maxlength="25"') ?>  
    <?= err('username') ?>  

    <label for="fullname">Full Name</label>  
    <?= html_text('fullname', 'maxlength="100"') ?>  
    <?= err('fullname') ?>  

    <label for="email">Email</label>  
    <?= html_text('email', 'maxlength="100"') ?>  
    <?= err('email') ?>  
  
    <label for="password">Password</label>  
    <?= html_password('password', 'maxlength="100"') ?>  
    <?= err('password') ?>  
  
    <label for="confirm">Confirm</label>  
    <?= html_password('confirm', 'maxlength="100"') ?>  
    <?= err('confirm') ?>  

    <label for="phone">Phone Number</label>  
    <?= html_text('phone', 'maxlength="20"') ?>  
    <?= err('phone') ?>  

    <label for="address">Address</label>  
    <?= html_text('address', 'maxlength="255"') ?>  
    <?= err('address') ?>  
  
    <section>  
        <button>Submit</button>  
        <button type="reset">Reset</button>  
    </section>  
</form>