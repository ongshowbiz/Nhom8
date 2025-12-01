<?php
$ASSETS_URL = '/scm/public/assets/';
$PUBLIC_URL = '/scm/public/';
?>

<aside id="sidebar">
    <ul>
        <li><a href="<?= $PUBLIC_URL ?>index.php?page=product">Quản Lý Sản phẩm</a></li>
        <li><a href="<?= $PUBLIC_URL ?>index.php?page=suppliers">Quản Lý Nhà Cung Ứng</a></li>
        <li><a href="<?= $PUBLIC_URL ?>index.php?page=orders">Quản Lý Đơn Hàng</a></li>
        <li><a href="<?= $PUBLIC_URL ?>index.php?page=customers">Quản Lý Khách Hàng</a></li>
    </ul>

    <div class = "user-section">
        <img src="<?= $PUBLIC_URL ?>images/admin.png" alt="User Icon" class="user-icon">
        <nav>
          <ul>
            <?php if (isset($_SESSION['admin_id'])): ?>
              <li><a href="<?= $PUBLIC_URL ?>?page=logout">Đăng xuất</a></li>
            <?php else: ?>
              <li><a href="<?= $PUBLIC_URL ?>?page=login">Đăng nhập</a></li>
            <?php endif; ?>
          </ul>
        </nav>
    </div>
    
    <div class="sidebar-contact">
        <h3>Contact Us</h3>
        <p>Email: tivua@langxitrum.com</p>
    </div>
</aside>