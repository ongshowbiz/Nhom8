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
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/order_list.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/footer.css">
</head>
<body>
    <?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="main-container">
        <div class="orders-container">
            <h1>🍄Đơn hàng của Xì Trum🍄</h1>

            <?php if (empty($orders)): ?>
                <div class="empty">
                    <p>Bạn chưa có đơn hàng nào</p>
                </div>
            <?php else: ?>
                <div class="orders-list">
                    <?php foreach ($orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <div class="order-info">
                                    <span class="order-id">Đơn hàng 🍄 #<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></span>
                                    <span class="order-date"><?= date('d/m/Y', strtotime($order['order_date'])) ?></span>
                                </div>
                                <span class="status" style="background: <?= $status_colors[$order['order_status']] ?>">
                                    <?= $status_text[$order['order_status']] ?>
                                </span>
                            </div>

                            <div class="order-body">
                                <div class="order-summary">
                                    <div class="summary-item">
                                        <span class="label">Tổng tiền:</span>
                                        <span class="value price"><?= number_format($order['order_total'], 0, ',', '.') ?> đ</span>
                                    </div>
                                </div>
                            </div>

                            <div class="order-footer">
                                <a href="index.php?page=order_detail&id=<?= $order['order_id'] ?>" class="btn-detail">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>