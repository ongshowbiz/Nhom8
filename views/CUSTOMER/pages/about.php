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
</head>
<body>
    
    <?php
    // 1. Tải Header (Menu)
    include __DIR__ . '/../partial/header.php';
    ?>

    <h1> 📣 LOA LOA LOA! CHÀO MỪNG CÁC "THƯỢNG ĐẾ" ĐÃ LẠC VÀO XỨ SỞ XÌ TRUM! 📣 </h1>
    <p>  Bạn đang tìm kiếm những món đồ "chất lừ", "xịn sò" mà giá lại "hạt dẻ"? Chúc mừng bạn, bạn đã đến đúng nơi rồi đấy! </p>
    <p>  Tại Cửa Hàng Xì Trum, chúng tớ không có phép thuật của Tí Vua để biến đá thành vàng, nhưng chúng tớ có "phép thuật" biến bạn trở nên xinh đẹp/ngầu hơn/vui vẻ hơn với những sản phẩm cực chất.</p>
    <h2>🌟 Vì sao nên chọn Xì Trum?</h2>
    <p>  Hàng cập nhật theo trend nhanh hơn cách người yêu cũ trở mặt.</p>
    <p>  Tư vấn nhiệt tình, vui tính, bao dễ thương.</p>
    <p>  Ship hàng nhanh như một cơn gió.</p>
    <p>  Đừng chỉ đứng nhìn, hãy bước vào và "oanh tạc" ngay thôi nào! Nếu cần tìm gì khó, cứ để Xì Trum lo!</p>
    <p>  Love you 3000, Team Cửa Hàng Xì Trum 💙</p>
    <?php 
    // 3. Tải Footer
    include __DIR__ . '/../partial/footer.php'; 
    ?>

    <script src="/scm/public/js/carousel.js"> </script>

</body>
</html>
