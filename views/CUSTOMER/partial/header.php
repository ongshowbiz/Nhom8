<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
$link = '/scm/views/CUSTOMER/index.php?page=product_list'
?>
<header>
  <div class="logo-container">
    <button id = "menu" class="menu">☰ Menu</button>
    <img src="<?= $PUBLIC_URL ?>images/logo.png" alt="Logo" class="logo">
      <h1>🍄Cửa Hàng Xì Trum🍄</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php?page=home"> Trang Chủ</a></li>
                <li><a href="index.php?page=about">Giới thiệu</a></li>
                <li><a href="index.php?page=contact">Liên Hệ</a></li>
                <li><a href="index.php?page=cart"> <i class="fa fa-shopping-cart"></i> 🛒</a></li>
            </ul>
        </nav>
</header>
  <aside id="sidebar">
    <button id="closeBtn">×</button>
      <!-- Menu items with dropdowns -->

<ul>
    <!-- 1. LOẠI SẢN PHẨM -->
    <li class="dropdown">
        <a href="index.php?page=product_type">Loại sản phẩm</a>
    </li>

    <!-- 2. SẢN PHẨM -->
    <li class="dropdown">
        <a href="index.php?page=product_list">Sản phẩm</a>
    </li>
    <!-- LỊCH SỬ ĐƠN HÀNG -->
    <li class="dropdown">
        <a href="index.php?page=order_list">Lịch sử đơn hàng</a>
    </li>
</ul>

<div class="user-section">
    
    <div class="user-left">
        <img src="<?= $PUBLIC_URL ?>images/customer.png" alt="User Icon" class="user-icon">
        
        <?php if (isset($_SESSION['customer_name']) && !empty($_SESSION['customer_name'])): ?>
            <a href="index.php?page=profile_edit" class="mini-edit-btn">🔧 Sửa chữa</a>
        <?php endif; ?>
    </div>

    <div class="user-right">
        <?php if (isset($_SESSION['customer_name']) && !empty($_SESSION['customer_name'])): ?>
            
            <div class="user-greeting">
                👋 Xin Chào Xì Trum<br> 
                <b><?php echo htmlspecialchars($_SESSION['customer_name']); ?></b>
            </div>
            
            <a href="index.php?page=logout" id="btn-logout">🍄Logout</a>

        <?php else: ?>
            <a href="index.php?page=login" id="btn-login">🍄Login </a> 
            <a href="index.php?page=register" id="btn-register">🍄Register</a>
        <?php endif; ?>
    </div>
</div>
    <div class="sidebar-contact">
        <h3>Contact Us</h3>
        <p>Email: tivua@langxitrum.com </p>
    </div>
  </aside>
    <!-- OVERLAY MỜ -->
  <div id="overlay"></div>
  <script src="<?= $ASSETS_URL ?>js/header.js"></script>
