<?php
$stock_status = $product['quantity'] > 0 ? 'Còn hàng' : 'Hết hàng';
$current_url = htmlspecialchars("index.php?page=product_detail&id={$product['product_id']}");

$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public';
$VIEWS_URL = '/scm/views/CUSTOMER/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['product_name']) ?> - Chi tiết</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css"> 
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/submenu.css"> 
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/product_detail.css"> 
</head>
<body>
    
    <?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="product-detail-container">
        
        <div class="main-info">
            <div class="image-gallery">
                    <?php
                        // 1. Xác định đường dẫn ảnh
                        // Nếu có tên ảnh trong DB, nối thêm đường dẫn thư mục images/ vào trước
                        if (!empty($product['image_url'])) {
                            $img_src = $ASSETS_URL . 'anhsp/' .$product['image_url'];
                        } else {
                        // 2. Nếu không có ảnh, dùng ảnh mặc định trong thư mục images
                            $img_src = $ASSETS_URL . 'anhsp/placeholder.jpg';
                        }
                    ?>
                        <img src="<?= htmlspecialchars($img_src) ?>" 
                            alt="<?= htmlspecialchars($product['product_name']) ?>" 
                            class="card-image">
                </div>

            <div class="info-area">
                <h1><?= htmlspecialchars($product['product_name']) ?> - <?= htmlspecialchars($product['brand'] ?? 'Chưa rõ') ?></h1>
          
                <form action="index.php?page=add_to_cart" method="POST">
                    <div class="quantity-section">
                        <h4>Quantity</h4>
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" class="quantity-input">
                    </div>

                    <div class="price-buy">
                        <div class="price"><?= number_format($product['price'], 0, ',', '.') ?> đ</div>
                        
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <input type="hidden" name="redirect_url" value="<?= $current_url ?>">

                        <button type="submit" name="buy_now" class="buy-btn">Mua ngay</button>
                        <button type="submit" class="add-to-cart-btn">Add to cart 🛒</button>
                    </div>
                    
                    <p style="color: <?= $product['quantity'] > 0 ? 'green' : 'red' ?>; font-weight: bold;">
                        Trạng thái: <?= $stock_status ?>
                    </p>
                </form>

            </div>
        </div>

        <div class="tabs-section">
            <div class="tabs-header">
                <a href="#descriptions" class="active">Descriptions</a>
            </div>

            <div class="tab-content" id="descriptions">
                <h2>Overview</h2>
                <p><?= htmlspecialchars($product['description'] ?? 'Sản phẩm đang được cập nhật mô tả chi tiết.') ?></p>
                
                <ul>
                    <li><strong>Brand:</strong> <?= htmlspecialchars($product['brand'] ?? 'N/A') ?></li>
                    <li><strong>Category:</strong> <?= htmlspecialchars($product['type_name'] ?? 'N/A') ?></li>
                    <li><strong>Description:</strong> <?= htmlspecialchars($product['description'] ?? 'N/A') ?></li>
                </ul>
            </div>
            </div>

        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="related-grid">
                <?php if (!empty($related_products)): ?>
                    <?php foreach ($related_products as $related): ?>
                        <a href="<?= $VIEWS_URL ?>index.php?page=product_detail&id=<?= $related['product_id'] ?>" class="related-card">
                            <img src="<?= htmlspecialchars($related['image_url'] ?? $ASSETS_URL.'images/placeholder.jpg') ?>" 
                                 alt="<?= htmlspecialchars($related['product_name']) ?>">
                            <p><?= htmlspecialchars($related['product_name']) ?></p>
                            <div class="price"><?= number_format($related['price'], 0, ',', '.') ?> đ</div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm liên quan nào.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php include __DIR__ . '/../partial/footer.php'; ?>
    <script src="<?= $ASSETS_URL ?>js/header.js"></script>
</body>
</html>