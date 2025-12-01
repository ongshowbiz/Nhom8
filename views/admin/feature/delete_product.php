<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>XÓA SẢN PHẨM</title>
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/submenu.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/xoasua.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
    </head>

    <body>
        <?php
        include __DIR__ . '/../partial/header.php';
        ?>

        <div class="main-body-wrapper">
            <?php
            include __DIR__ . '/../partial/menu.php';
            ?>

            <main>
                <div class="container" style="padding: 80px;">
                    <h2>XÁC NHẬN XÓA SẢN PHẨM</h2>
                    <p>BẠN CÓ CHẮC CHẮN MUỐN XÓA SẢN PHẨM:<strong><?= htmlspecialchars($product['product_name']) ?></strong>?</p>
                    <form action="<?= $PUBLIC_URL ?>index.php?page=delete_product&id=<?= $product['product_id'] ?>" method="POST">

                        <button type ="submit" name="delete_product" class="btn btn-danger">Xóa</button>
                        <a href="<?= $PUBLIC_URL ?>index.php?page=product" class="btn btn-secondary">Hủy</a>

                    </form>
                </div>
            </main>
        </div>

        <?php
        include __DIR__ . '/../partial/footer.php';
        ?>
    </body>
</html>