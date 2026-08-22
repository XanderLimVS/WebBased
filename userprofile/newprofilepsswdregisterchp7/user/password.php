<?php
include 'includes/base.php';

// Authenticated users
auth();

if (is_post()) {
    $password     = req('password');
    $new_password = req('new_password');
    $confirm      = req('confirm');

    //Validate: password
    if ($password == '') {
        $_err['password'] = 'Required';
    }
    else if (strlen($password) < 5 || strlen($password) > 100) {
        $_err['password'] = 'Between 5-100 characters';
    }
    else {
        $stm = $_db->prepare('
            SELECT COUNT(*) FROM users
            WHERE password = SHA1(?) AND id = ?
        ');
        $stm->execute([$password, $_user->id]);

        if ($stm->fetchColumn() == 0) {
            $_err['password'] = 'Not matched';
        }
    }

    //validate: new_password
    if ($new_password == '') {
        $_err['new_password'] = 'Required';
    }
    else if (strlen($new_password) < 5 || strlen($new_password) > 100) {
        $_err['new_password'] = 'Between 5-100 characters';
    }

    //validate: confirm
    if (!$confirm) {
        $_err['confirm'] = 'Required';
    }
    else if (strlen($confirm) < 5 || strlen($confirm) > 100) {
        $_err['confirm'] = 'Between 5-100 characters';
    }
    else if ($confirm != $new_password) {
        $_err['confirm'] = 'Not matched';
    }

    //DB operation
    if (!$_err) {
        //update user (password)
        $stm = $_db->prepare('
            UPDATE users
            SET password = SHA1(?)
            WHERE id = ?
        ');
        $stm->execute([$new_password, $_user->id]);

        temp('info', 'Record updated');
        redirect('/');
    }
}

$_title = 'User | Password';
include 'includes/header.php';
?>

<form method="post" class="form">
    <label for="password">Password</label>
    <?= html_password('password', 'maxlength="100"') ?>
    <?= err('password') ?>

    <label for="new_password">New Password</label>
    <?= html_password('new_password', 'maxlength="100"') ?>
    <?= err('new_password') ?>

    <label for="confirm">Confirm</label>
    <?= html_password('confirm', 'maxlength="100"') ?>
    <?= err('confirm') ?>

    <section>
        <button>Submit</button>
        <button type="reset">Reset</button>
    </section>
</form>

<?php
include 'includes/footer.php';
