<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>ĐĂNG XUẤT</title>
        <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    </head>

    <body>
        <?php
        include __DIR__ . '/partial/header.php';
        ?>

        <div class="main-body-wrapper">
            <?php
            include __DIR__ . '/partial/menu.php';
            ?>

            <main>
                <div class="container" style="padding: 80px;">
                    <h2>ĐĂNG XUẤT KHỎI HỆ THỐNG</h2>
                    <p>BẠN CHẮC CHẮN MUỐN ĐĂNG XUẤT?</p>
                    <a href="/scm/public/index.php?page=logout_confirm" class="btn btn-danger">Đăng xuất</a>
                    <a href="<?= $PUBLIC_URL ?>index.php?page=home" class="btn btn-secondary">Hủy</a>
                </div>
            </main>
        </div>

        <?php
        include __DIR__ . '/partial/footer.php';
        ?>
    </body>
</html>