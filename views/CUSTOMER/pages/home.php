<?php
?>
<link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/home.css">
<?php if (empty($home_product_groups)): ?>
    <p style="text-align: center; padding: 50px;">
        Không có sản phẩm nào để hiển thị.
    </p>
<?php else: ?>
    
    <?php foreach ($home_product_groups as $group): ?>
    
    <section class="home-product-group">
        
        <div class="home-group-header">
            <h2><?= htmlspecialchars($group['type_name']) ?></h2>
            
            <a href="index.php?page=product_list&type_id=<?= $group['type_id'] ?>" class="view-all-link">
                Xem tất cả
            </a>
        </div>
        
        <div class="product-row">
            
            <?php foreach ($group['products'] as $product): ?>
                
                <div class="product-card">
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

                    
                    <div class="card-content">
                        <h3 class="card-title">
                            <?= htmlspecialchars($product['product_name']) ?>
                        </h3>
                        
                        <p class="card-description">
                            <?= htmlspecialchars($product['description'] ?? 'Chưa có mô tả.') ?>
                        </p>
                        
                        <div class="card-price">
                            <?= number_format($product['price'], 0, ',', '.') ?> đ
                        </div>
                        
                        <form action="index.php?page=add_to_cart" method="POST" class="card-actions">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            
                            <input type="hidden" name="redirect_url" value="index.php?page=home">

                            <input type="number" name="quantity" value="1" min="1" 
                                   max="<?= $product['quantity'] ?>" class="quantity-input">
                            
                            <button type="submit" class="add-to-cart-btn">THÊM</button>
                        </form>
                    </div>
                </div>
                
            <?php endforeach; ?>
            
        </div> </section> <?php endforeach; ?>

<?php endif; ?>