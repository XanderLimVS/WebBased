<?php
include '../base.php';

// ----------------------------------------------------------------------------

$arr = $_db->query('SELECT * FROM product')->fetchAll();

// ----------------------------------------------------------------------------

$_title = 'Product | Index';
include '../_head.php';
?>

<style>
    .popup {
        width: 100px;
        height: 100px;
    }
</style>

<p>
    <button data-get="insert.php">Insert</button>
</p>

<p><?= count($arr) ?> record(s)</p>

<table class="table">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Price</th>
        <th></th>
    </tr>

    <?php foreach ($arr as $p): ?>
    <tr>
        <td><?= $p->id ?></td>
        <td><?= $p->name ?></td>
        <td><?= $p->price ?></td>
        <td>
            <button data-get="update.php?id=<?= $p->id ?>">Update</button>
            <button data-post="delete.php?id=<?= $p->id ?>">Delete</button>
            <img src="/photos/<?= $p->photo ?>" class="popup">
        </td>
    </tr>
    <?php endforeach ?>
</table>

<?php
include '../_foot.php';