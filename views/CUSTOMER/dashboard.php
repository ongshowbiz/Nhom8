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
    <title>Bán Hàng</title>
</head>
<body>
    
    <?php include __DIR__ . '/partial/header.php'; ?>

    <?php include __DIR__ . '/pages/home.php'; ?>

    <?php include __DIR__ . '/partial/footer.php'; ?>
    <script src="<?= $ASSETS_URL ?>js/header.js"></script>
    
</body>

</html>