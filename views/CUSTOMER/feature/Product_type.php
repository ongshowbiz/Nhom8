<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';

$typelist = $product_types ?? [];

function Icon($tenLoai) {
    $icon = [
    'default' => '📦',
        'rau củ' => '🥦',
        'trái cây' => '🍎',
        'thực phẩm' => '🍲',
        'gia vị' => '🧂',
        'bánh kẹo' => '🍬',
        'đồ dùng' => '🧴',
        'đồ uống' => '🥤'
    ];
    $ten = strtolower($tenLoai);
    
    foreach($icon as $key => $icons) {
        if($key !== 'default' && strpos($ten, $key) !== false) {
            return $icons;
        }
    }
    return $icon['default'];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục sản phẩm</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/submenu.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/product_type.css">
</head>

<body>
    <?php include __DIR__ . '/../partial/header.php'; ?>
    
    <div class="main-body-wrapper">
        <div class="content-area">
            <div class="page-header">
                <h1>Loại Sản Phẩm </h1>
            </div>
            
            <?php if (count($typelist) > 0): ?>
                <div class="categories-grid">
                    <?php foreach($typelist as $type): ?>
                        <a href="index.php?page=product_list&type_id=<?php echo $type['product_type_id']; ?>" class="category-card">
                            <div class="category-icon">
                                <?php echo Icon($type['type_name']); ?>
                            </div>
                            <div class="category-name">
                                <?php echo htmlspecialchars($type['type_name']); ?>
                            </div>
                            <div class="category-count">
                                <?= $type['total_products']?> sản phẩm </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-data">
                    <p>Không có danh mục sản phẩm nào</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include __DIR__ . '/../partial/footer.php'; ?>
    <script src="<?= $ASSETS_URL ?>js/header.js"></script>
</body>
</html>