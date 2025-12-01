<?php
$ASSETS_URL = '/scm/public/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/submenu.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
    <title>Liên Hệ</title>
    <style>
        h2 {
            text-align: center;
            color: #3955d0ff;
        }
        h3{
            text-align: center;
            color: #3955d0ff;
        }
        p {
            text-align: center;
            font-size: 18px;
            line-height: 1.6;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    
    <?php
    // 1. Tải Header (Menu)
    include __DIR__ . '/../partial/header.php';

    ?>

            <h2>Nếu bạn có thắc gì thì vui lòng liên hệ</h2>
            <p> 123 Đường Xì, Quận Trum, TP. HCM</p>
            <p>Tí Vua: (028) 1234 5678</p>
            <p>Tí Quản: (028) 8910 1112</p>
            <p>Email: tivua@langxitrum.com</p>


    <?php 
    // 3. Tải Footer
    include __DIR__ . '/../partial/footer.php'; 
    ?>

    <script src="/scm/public/js/carousel.js"> </script>

</body>
</html>