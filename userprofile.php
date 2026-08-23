<?php
include 'includes/base.php';

auth();

if (is_get()) {
    $stm = $_db->prepare('SELECT * FROM users WHERE id = ?');
    $stm->execute([$_user->id]);
    $u = $stm->fetch();

    // User not found
    if (!$u) {
        redirect('/');
    }

    // Convert database data into variables
    extract((array)$u);

    // Save current photo
    $_SESSION['photo'] = $u->photo;
}

// POST: Update profile
if (is_post()) {

    // Get submitted data
    $email = req('email');
    $name  = req('name');

    // Keep old photo
    $photo = $_SESSION['photo'];

    // Get uploaded file
    $f = get_file('photo');

    // Validate Email
    if ($email == '') {
        $_err['email'] = 'Required';
    }
    else if (strlen($email) > 100) {
        $_err['email'] = 'Maximum 100 characters';
    }
    else if (!is_email($email)) {
        $_err['email'] = 'Invalid email';
    }
    else {

        // Check if another user already uses this email
        $stm = $_db->prepare('SELECT COUNT(*) FROM users WHERE email = ? AND id != ?');
        $stm->execute([$email, $_user->id]);

        if ($stm->fetchColumn() > 0) {
            $_err['email'] = 'Duplicated';
        }
    }

    // Validate Name
    if ($name == '') {
        $_err['name'] = 'Required';
    }
    else if (strlen($name) > 100) {
        $_err['name'] = 'Maximum 100 characters';
    }

    // Validate Photo
    if ($f) {
        // Check image type
        if (!str_starts_with($f->type, 'image/')) {
            $_err['photo'] = 'Must be an image';
        }

        // Check file size
        else if ($f->size > 1 * 1024 * 1024) {
            $_err['photo'] = 'Maximum 1MB';
        }
    }

    // Update Database
    if (!$_err) {
        // If user uploads a new photo
        if ($f) {
            // Delete old photo if it exists
            if ($photo && file_exists("photos/$photo")) {
                unlink("photos/$photo");
            }
            // Save new photo
            $photo = save_photo($f, 'photos');
        }

        // Update user information
        $stm = $_db->prepare('UPDATE users SET email = ?, name = ?, photo = ? WHERE id = ?');
        $stm->execute([$email, $name, $photo, $_user->id]);

        // Update logged-in user information
        $users->email = $email;
        $users->name  = $name;
        $users->photo = $photo;

        // Update session photo
        $_SESSION['photo'] = $photo;

        // Show message
        temp('info', 'Profile updated successfully');

        // Go back to home page
        redirect('/');
    }
}

$_title = 'My Profile';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/userprofile.css">
    <title>Profile</title>
</head>

<div class="profile-container">
    <h1>User Profile</h1>
    <form method="post" class="form" enctype="multipart/form-data">
        <label for="email">Email</label>
        <input type="email" name="email" maxlength="100">
        <?php if (isset($_err['email'])): ?>
            <span class="error"><?= $_err['email'] ?></span>
        <?php endif; ?>

        <label for="name">Name</label>
        <input type="text" name="name" maxlength="100">
        <?php if (isset($_err['name'])): ?>
            <span class="error"><?= $_err['name'] ?></span>
        <?php endif; ?>

        <label for="photo">Profile Photo</label>
        <label class="upload" tabindex="0">
            <input type="file" id="photo" name="photo" accept="image/*" hidden>
            <img src="/photos/<?= htmlspecialchars($photo ?? 'default.jpg') ?>" alt="Profile Photo">
        </label>
        <?php if (isset($_err['photo'])): ?>
            <span class="error"><?= htmlspecialchars($_err['photo']) ?></span>
        <?php endif; ?>

        <section>
            <button type="submit">Save</button>
            <button type="reset">Reset</button>
            <a href="/">Cancel</a>
        </section>
    </form>
</div>

<?php
include 'includes/footer.php';
?>