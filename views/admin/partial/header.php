<?php
$ASSETS_URL = $ASSETS_URL ?? '/scm/public/';
$PUBLIC_URL = $PUBLIC_URL ?? '/scm/views/admin/';
$isLogin = $isLogin ?? false; 
?>

<header>
  <?php if (! $isLogin): ?>
    <div class="logo-container">
      <img src="<?= $ASSETS_URL ?>images/logo1.png" alt="Logo" class="logo">
      <h1>Quản Lý Xì Trum</h1>
    </div>

    <nav>
      <ul>
        <li><a href="index.php?page=home"> Trang Chủ</a></li>
        <li><a href="index.php?page=contact">Liên Hệ</a></li>
      </ul>
    </nav>
  <?php else: ?>
  <?php endif; ?>
</header> 