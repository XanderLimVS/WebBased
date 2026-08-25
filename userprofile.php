<?php
include 'includes/base.php';

auth();
if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM users WHERE id = ?');
    $stm->execute([$_user->id]);
    $u = $stm->fetch();

    if (!$u) {
        redirect('/');
    }
    extract((array)$u);
}

if (is_post()) {
    $username  = req('username');
    $full_name = req('full_name');
    $email     = req('email');
    $phone     = req('phone');
    $address   = req('address');

    if ($username == '') {
        $_err['username'] = 'Required';
    }
    else if (strlen($username) > 50) {
        $_err['username'] = 'Maximum 50 characters';
    }

    if ($full_name == '') {
        $_err['full_name'] = 'Required';
    }
    else if (strlen($full_name) > 100) {
        $_err['full_name'] = 'Maximum 100 characters';
    }

    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }

    if ($phone == '') {
        $_err['phone'] = 'Required';
    }
    else if (strlen($phone) > 20) {
        $_err['phone'] = 'Maximum 20 characters';
    }

    if ($address == '') {
        $_err['address'] = 'Required';
    }
    else if (strlen($address) > 255) {
        $_err['address'] = 'Maximum 255 characters';
    }

    if (!$_err) {
        $stm = $_db->prepare('UPDATE users SET username = ?, full_name = ?, email = ?, phone = ?, address = ? WHERE id = ?');
        $stm->execute([$username, $full_name, $email, $phone, $address, $_user->id]);

        $_user->username  = $username;
        $_user->full_name = $full_name;
        $_user->email     = $email;
        $_user->phone     = $phone;
        $_user->address   = $address;

        temp('info', 'Profile updated successfully');
        redirect('/userprofile.php');
    }
}

$_title = 'User Profile';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/userprofile.css">
    <title>User Profile</title>
</head>
<body>

<div class="profile-container">
    <h1>User Profile</h1>
    <form method="post" class="form">
        <label for="username">USERNAME</label>
        <input type="text" id="username" name="username" maxlength="50" value="<?= htmlspecialchars($username ?? '') ?>">
        <?php if (isset($_err['username'])): ?>
            <span class="error"><?= htmlspecialchars($_err['username']) ?></span>
        <?php endif; ?>

        <label for="full_name">FULL NAME</label>
        <input type="text" id="full_name" name="full_name" maxlength="100" value="<?= htmlspecialchars($full_name ?? '') ?>">
        <?php if (isset($_err['full_name'])): ?>
            <span class="error"><?= htmlspecialchars($_err['full_name']) ?></span>
        <?php endif; ?>

        <label for="email">EMAIL</label>
        <input type="email" id="email" name="email" maxlength="100" value="<?= htmlspecialchars($email ?? '') ?>">
        <?php if (isset($_err['email'])): ?>
            <span class="error"><?= htmlspecialchars($_err['email']) ?></span>
        <?php endif; ?>

        <label for="phone">PHONE</label>
        <input type="tel" id="phone" name="phone" maxlength="20" value="<?= htmlspecialchars($phone ?? '') ?>">
        <?php if (isset($_err['phone'])): ?>
            <span class="error"><?= htmlspecialchars($_err['phone']) ?></span>
        <?php endif; ?>

        <label for="address">ADDRESS</label>
        <textarea id="address" name="address" rows="4" maxlength="255" ><?= htmlspecialchars($address ?? '') ?></textarea>
        <?php if (isset($_err['address'])): ?>
            <span class="error"><?= htmlspecialchars($_err['address']) ?></span>
        <?php endif; ?>

        <div class="account-info">
            <div>
                <span>COINS</span>
                <strong><?= htmlspecialchars($coins ?? 0) ?></strong>
            </div>

            <div>
                <span>STATUS</span>
                <strong><?= htmlspecialchars($user_status ?? 'active') ?></strong>
            </div>

            <div>
                <span>ACCOUNT TYPE</span>
                <strong><?= htmlspecialchars($user_type ?? 'user') ?></strong>
            </div>
        </div>

        <section>
            <button type="submit">SAVE</button>
            <button type="reset">RESET</button>
            <a href="/">CANCEL</a>
        </section>
        </form>
</div>
</body>
</html>

<?php
include 'includes/footer.php';
?>
