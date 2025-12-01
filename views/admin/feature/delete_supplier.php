<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xóa Nhà Cung Ứng - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/xoasua.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="main-body-wrapper">
    <?php include __DIR__ . '/../partial/menu.php'; ?>
    <div class="container" style="padding: 80px;">
        <h2>Xóa Nhà Cung Ứng #<?= $supplier['supplier_id'] ?></h2>
        <p>Bạn có chắc muốn xóa nhà cung ứng <strong><?= htmlspecialchars($supplier['supplier_name']) ?></strong> không?</p>

        <form action="<?= $PUBLIC_URL ?>index.php?page=delete_supplier&id=<?= $supplier['supplier_id'] ?>" method="POST">

            <button type="submit" name="confirm_delete" class="btn btn-danger">Xóa</button>
            <a href="<?= $PUBLIC_URL ?>index.php?page=suppliers" class="btn btn-secondary">Hủy</a>
            
        </form>
    </div>
</div>
<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>