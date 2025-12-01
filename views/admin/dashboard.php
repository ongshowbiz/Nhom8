<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>ADMIN DASHBOARD || OGW </title>

    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>css/submenu.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
    <?php
    include __DIR__ . '/partial/header.php';
    ?>

   <div class="main-body-wrapper"> 
        <?php
        include __DIR__ . '/partial/menu.php';
        ?>

        <div class="content-area">
            <main>
                <?php include __DIR__ . '/pages/home.php'; ?>
            </main>
        </div>
    </div>

    <?php include __DIR__ . '/partial/footer.php'; ?>

    <script src="<?php echo $ASSETS_URL; ?>js/carousel.js"></script>
</body>
</html>
