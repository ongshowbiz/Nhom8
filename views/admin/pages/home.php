<?php
$ASSETS_URL = $ASSETS_URL ?? '/scm/public/';
$PUBLIC_URL = $PUBLIC_URL ?? '/scm/public/';
?>

<section class="features" id="features">
    <div class="container">
        <h2>QUẢN LÝ WEBSITE CỬA HÀNG XÌ TRUM</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3><a href="<?= $PUBLIC_URL ?>index.php?page=product">Quản Lý Sản Phẩm</a></h3>
                <p>Thêm, sửa, xóa và phân loại sản phẩm trong kho.</p>
            </div>
            <div class="feature-card">
                <h3><a href="<?= $PUBLIC_URL ?>index.php?page=suppliers">Quản Lý Nhà Cung Ứng</a></h3>
                <p>Nhà cung ứng và lịch sử giao dịch.</p>
            </div>
            <div class="feature-card">
                <h3><a href="<?= $PUBLIC_URL ?>index.php?page=orders">Quản Lý Đơn Hàng</a></h3>
                <p>Xử lý đơn hàng khách hàng nhanh chóng, cập nhật trạng thái giao hàng và quản lý lịch sử mua hàng chi tiết.</p>
            </div>
            <div class="feature-card">
                <h3><a href="<?= $PUBLIC_URL ?>index.php?page=customers">Quản Lý Khách Hàng</a></h3>
                <p>Lưu trữ thông tin khách hàng.</p>
            </div>
        </div>
    </div>
</section>