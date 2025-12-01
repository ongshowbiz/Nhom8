<?php
$ASSETS_URL = '/scm/public/';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng</title>
    
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/checkout.CSS">
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/styles.CSS">
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/footer.CSS">
</head>
<body>
    <?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="main-container">
        <div class="checkout-container">
            <h1>Đặt hàng</h1>

            <?php if (!empty($msg_error)): ?>
                <div class="error"><?= $msg_error ?></div>
            <?php endif; ?>

            <?php if (empty($selectedProducts)): ?>
                <div class="empty">
                    <p>Chưa có sản phẩm nào được chọn!</p>
                    <a href="index.php?page=cart">Quay lại giỏ hàng</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="checkout-layout">
                        <div class="left">
                            <h2>Thông tin giao hàng</h2>
                            
                            <label>Họ và tên <span>*</span></label>
                            <input type="text" name="recipient_name" value="<?= htmlspecialchars($customer_info['customer_fullname'] ?? '') ?>" required>

                            <label>Số điện thoại <span>*</span></label>
                            <input type="text" name="recipient_phone" value="<?= htmlspecialchars($customer_info['customer_phone'] ?? '') ?>" required>

                            <label>Địa chỉ giao hàng <span>*</span></label>
                            <textarea name="ship_address" required><?= htmlspecialchars($customer_info['customer_address'] ?? '') ?></textarea>

                            <label>Ghi chú</label>
                            <textarea name="ship_note"></textarea>
                        </div>

                        <div class="right">
                            <h2>Đơn hàng (<?= count($selectedProducts) ?> sản phẩm)</h2>
                            
                            <div class="order-header-row">
                                <span class="col-prod">Sản phẩm</span>
                                <span class="col-qty">Số lượng</span>
                                <span class="col-total">Thành tiền</span>
                            </div>

                            <div class="products-list">
                                <?php foreach ($selectedProducts as $item): ?>
                                    <div class="product-item">
                                        <div class="prod-info">                        
                                            <?php
                                                if (!empty($item['image_url'])) {
                                                     $img_src = $ASSETS_URL . 'anhsp/' .$item['image_url'];
                                                } else {

                                                    $img_src = $ASSETS_URL . 'anhsp/placeholder.jpg';
                                                }
                                            ?>
                                            <img src="<?= htmlspecialchars($img_src) ?>" 
                                                alt="<?= htmlspecialchars($item['product_name']) ?>" 
                                                class="card-image">
                                            <div class="prod-details">
                                                <div class="prod-name"><?= $item['product_name'] ?></div>
                                                <div class="unit-price">Đơn giá: <?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                                            </div>
                                        </div>

                                        <div class="prod-qty">
                                            x<?= $item['quantity'] ?>
                                        </div>

                                        <div class="prod-subtotal">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="summary">
                                <div class="total-row">
                                    <span>Tổng cộng:</span>
                                    <span><?= number_format($totalAmount, 0, ',', '.') ?> đ</span>
                                </div>
                            </div>

                            <button type="submit" name="submit_checkout">Xác nhận đặt hàng</button>
                            <a href="index.php?page=cart" class="back"> Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>