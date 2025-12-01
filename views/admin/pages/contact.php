<?php
$ASSETS_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/submenu.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
    
    <title>LIÊN HỆ QUẢN TRỊ VIÊN</title>
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
            <div class="container contact-container" style="padding-top: 80px; padding-bottom: 80px; min-height: 60vh;">
                <h2><b>LIÊN HỆ QUẢN LÝ HOẶC BỘ PHẬN HỖ TRỢ</b></h2>
                <p>NẾU CÓ THẮC MẮC VUI LÒNG LIÊN HỆ CÁC KÊNH SAU:</p>

                <div class="contact-info">
                    <p><strong>Email hỗ trợ:</strong>Jack97@groceryonline.com</p>
                    <p><strong>Số điện thoại:</strong> 0901 236 184</p>
                    <p><strong>Địa chỉ:</strong>123 Đường Nguyễn Văn Trỗi, Quận Tân Bình, TP. Hồ Chí Minh</p>
                </div>

                <div class="contact-note" style="margin-top: 20px;">
                    <p>Nếu bạn gặp lỗi hệ thống hoặc không truy cập được hãy liên lạc với chúng tôi để được hỗ trợ sớm nhất</p>
                </div>
            </div>
        </main>
    </div>


    <?php 
    include __DIR__ . '/../partial/footer.php'; 
    ?>

    <script src="<?= $ASSETS_URL ?>js/carousel.js"> </script>
</body>
</html>