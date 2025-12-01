<?php
$ASSETS_URL = '/scm/public/';

$status_text = [
    'confirmed' => 'Đã xác nhận',
    'processing' => 'Đang xử lý',
    'pending' => 'Đang chuẩn bị hàng',
    'delivered' => 'Đang giao hàng',
    'completed' => 'Hoàn thành',
    'cancelled' => 'Đã hủy',
    'returned' => 'Đã trả hàng',
    'refunded' => 'Đã hoàn tiền'
];

$status_colors = [
    'confirmed' => '#ffc107',
    'processing' => '#2196F3',
    'pending' => '#2196F3',
    'delivered' => '#9C27B0',
    'completed' => '#4CAF50',
    'cancelled' => '#f44336',
    'returned' => '#FF9800',
    'refunded' => '#795548'
];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= $order['order_id'] ?></title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/order_detail.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
</head>
<body>
    <?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="main-container">
        <div class="detail-container">
            <div class="detail-header">
                <h1>Chi tiết đơn hàng 🍄#<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></h1>
                <a href="index.php?page=my_orders" class="btn-back">← Quay lại</a>
            </div>

            <div class="detail-layout">
                <!-- Thông tin đơn hàng -->
                <div class="info-box">
                    <h2>Thông tin đơn hàng</h2>
                    <table class="info-table">
                        <tr>
                            <td>Mã đơn hàng:</td>
                            <td><strong>#<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Ngày đặt:</td>
                            <td><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></td>
                        </tr>
                        <tr>
                            <td>Trạng thái:</td>
                            <td>
                                <span class="status" style="background: <?= $status_colors[$order['order_status']] ?>">
                                    <?= $status_text[$order['order_status']] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Tổng tiền:</td>
                            <td><strong class="price"><?= number_format($order['order_total'], 0, ',', '.') ?> đ</strong></td>
                        </tr>
                    </table>
                </div>

                <!-- Thông tin giao hàng -->
                <div class="info-box">
                    <h2>Thông tin giao hàng</h2>
                    <table class="info-table">
                        <tr>
                            <td>Người nhận:</td>
                            <td><strong><?= htmlspecialchars($order['recipient_name']) ?></strong></td>
                        </tr>
                        <tr>
                            <td>Số điện thoại:</td>
                            <td><?= htmlspecialchars($order['recipient_phone']) ?></td>
                        </tr>
                        <tr>
                            <td>Địa chỉ:</td>
                            <td><?= htmlspecialchars($order['ship_address']) ?></td>
                        </tr>
                        <?php if (!empty($order['ship_note'])): ?>
                        <tr>
                            <td>Ghi chú:</td>
                            <td><?= htmlspecialchars($order['ship_note']) ?></td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>

            <!-- Danh sách sản phẩm -->
            <div class="products-box">
                <h2>Sản phẩm đã đặt (<?= count($order_items) ?>)</h2>
                <div class="products-list">
                    <?php foreach ($order_items as $item): ?>
                        <div class="product-item">
                            <img src="<?= $ASSETS_URL ?>anhsp/<?= basename($item['image_url']) ?>" 
                            alt="<?= htmlspecialchars($item['product_name']) ?>"
                            onerror="this.src='<?= $ASSETS_URL ?>images/no-image.png'">
                            <div class="product-info">
                                <div class="product-name"><?= htmlspecialchars($item['product_name']) ?></div>
                                <div class="product-price">
                                    <?= number_format($item['price'], 0, ',', '.') ?> đ x <?= $item['quantity'] ?>
                                </div>
                            </div>
                            <div class="product-total">
                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                    <div class="total-row final">
                        <span>Tổng cộng:</span>
                        <span class="price"><?= number_format($order['order_total'], 0, ',', '.') ?> đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>