<?php
$clear_all_link = 'index.php?page=product_list';
$query_params = $_GET;
unset($query_params['p']);
$pagination_base_url = 'index.php?' . http_build_query($query_params);

$filter_type_id = $filter_type_id ?? 0;
$filter_prices = $filter_prices ?? [];
$filter_brands = $filter_brands ?? [];
$message = $message ?? '';
$total_products = $total_products ?? 0;
$products = $products ?? [];
$price_ranges = $price_ranges ?? [];
$product_types = $product_types ?? [];
$brands = $brands ?? [];
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cửa hàng</title>
<link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css">
<link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/submenu.css">
<link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
<link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/product_list.css">
</head>
<body>

<?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="shop-container">
        
        <aside class="shop-sidebar">
        <form action="index.php" method="GET">
            <input type="hidden" name="page" value="product_list">

            <div class="filter-group">
                <h3>Bộ lọc sản phẩm🍄</h3>

                <h4>Danh mục</h4>
                <ul>
                    <li>
                        <label>
                            <input type="radio" name="type_id" value="0"
                                <?= ($filter_type_id == 0) ? 'checked' : '' ?>>
                            Tất cả sản phẩm
                        </label>
                    </li>
                    <?php foreach ($product_types as $type): ?>
                        <li>
                            <label>
                                <input type="radio" name="type_id" value="<?= $type['product_type_id'] ?>"
                                    <?= ($filter_type_id == $type['product_type_id']) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($type['type_name']) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <hr class="sidebar-divider">

            <div class="filter-group">
                <h4>Mức giá</h4>
                <ul>
                    <?php foreach ($price_ranges as $key => $value): ?>
                        <li>
                            <label>
                                <input type="checkbox" name="price[]" value="<?= $key ?>"
                                    <?= (in_array($key, $filter_prices)) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($value) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <hr class="sidebar-divider">

            <div class="filter-group">
                <h4>Thương hiệu</h4>
                <ul>
                    <?php foreach ($brands as $brand): ?>
                        <li>
                            <label>
                                <input type="checkbox" name="brand[]" value="<?= htmlspecialchars($brand['brand']) ?>"
                                    <?= (in_array($brand['brand'], $filter_brands)) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($brand['brand']) ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <button type="submit" class="filter-submit-btn">Lọc</button>

            <a href="index.php?page=product_list" class="clear-filter-link">Xóa tất cả bộ lọc</a>

        </form>
    </aside>

        <main class="shop-main">
            
            <?php if (!empty($message)): ?>
                <div class="shop-message">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <div class="product-grid">
                
                <?php if (!empty($products) && is_array($products)): ?>
                    <?php foreach($products as $product): ?>
                        
                    <div class="product-card">
                            <div class="card-content">
                            <?php
                                if (!empty($product['image_url'])) {
                                    $img_src = $ASSETS_URL . 'anhsp/' .$product['image_url'];
                                } else {

                                    $img_src = $ASSETS_URL . 'anhsp/placeholder.jpg';
                                }
                            ?>
                                <img src="<?= htmlspecialchars($img_src) ?>" 
                                    alt="<?= htmlspecialchars($product['product_name']) ?>" 
                                    class="card-image">
                                <h3 class="card-title">
                                    <a href="index.php?page=product_detail&id=<?= $product['product_id'] ?>" class="stretched-link">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                    </a>
                            </h3>
            
                                    <p class="card-description"><?= htmlspecialchars($product['description'] ?? 'Chưa có mô tả.') ?> </p>
                                    <div class="card-price"><?= number_format($product['price'], 0, ',', '.') ?>  </div>
                            </div>

                            <form action="index.php?page=add_to_cart" method="POST" class="card-actions">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="redirect_url" 
                                    value="index.php?<?= htmlspecialchars(http_build_query($_GET)) ?>">
                                <input type="number" name="quantity" value="1" min="1" max="<?= $product['quantity'] ?>" class="quantity-input">
                                <button type="submit" class="add-to-cart-btn">THÊM</button>
                            </form>
                        </div>

                    <?php endforeach; ?>
                            
                <?php else: ?>
                    <p>Không tìm thấy sản phẩm nào phù hợp với bộ lọc.</p>
                <?php endif; ?>

            </div> 
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="<?= $pagination_base_url ?>&p=<?= $i ?>" 
                                class="<?= ($i == $current_page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

        </main> 
    </div> 
<?php include __DIR__ . '/../partial/footer.php'; ?>

<script src="<?= $ASSETS_URL ?>js/header.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const messageElement = document.querySelector('.shop-message');
    if (messageElement) {
        setTimeout(() => {
            messageElement.style.transition = 'opacity 0.5s ease';
            messageElement.style.opacity = '0';
            setTimeout(() => { messageElement.style.display = 'none'; }, 500);
        }, 3000);
    }
});
</script>
</body>
</html>