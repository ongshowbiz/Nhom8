<?php
$ASSETS_URL = '/scm/public/';

// Lấy order_id từ session hoặc URL
$order_id = $_SESSION['last_order_id'] ?? ($_GET['order_id'] ?? 0);

if ($order_id <= 0) {
    header("Location: index.php?page=home");
    exit;
}

// Lấy thông tin đơn hàng
$order = $this->model->getOrderById($order_id);
if (!$order || $order['customer_id'] != $_SESSION['customer_id']) {
    header("Location: index.php?page=home");
    exit;
}

// Lấy chi tiết các sản phẩm trong đơn hàng
$order_items = $this->model->getOrderItems($order_id);

// Xóa session last_order_id
unset($_SESSION['last_order_id']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/order_success.css">
</head>
<body>
<div class="content-area">
    <div class="success-container">
        <!-- Success animation -->
        <div class="success-animation">
            <div class="checkmark-circle">
                <div class="checkmark"></div>
            </div>
        </div>

        <h1 class="success-title">Đặt hàng thành công!</h1>
        <p class="success-message">
            Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.
        </p>

        <div class="order-details-container">
            <div class="order-info-section">
                <div class="info-card">
                    <h2 class="card-title">Thông tin đơn hàng</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Mã đơn hàng:</span>
                            <span class="info-value order-id">#<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Ngày đặt:</span>
                            <span class="info-value"><?= date('d/m/Y', strtotime($order['order_date'])) ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Trạng thái:</span>
                            <span class="status-badge status-<?= $order['order_status'] ?>">
                                <?php
                                $status_text = [
                                    'confirmed' => 'Đã xác nhận',
                                    'processing' => 'Đang xử lý',
                                    'delivered' => 'Đang giao hàng',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy',
                                    'returned' => 'Đã trả hàng',
                                    'refunded' => 'Đã hoàn tiền'
                                ];
                                echo $status_text[$order['order_status']] ?? 'Chưa xác định';
                                ?>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tổng tiền:</span>
                            <span class="info-value total-price"><?= number_format($order['order_total'], 0, ',', '.') ?> đ</span>
                        </div>
                    </div>
                </div>

                <!-- Thông tin người nhận -->
                <div class="info-card">
                    <h2 class="card-title">Thông tin người nhận</h2>
                    <div class="recipient-info">
                        <div class="recipient-item">
                            <span class="recipient-icon"></span>
                            <div>
                                <div class="recipient-label">Họ và tên</div>
                                <div class="recipient-value"><?= htmlspecialchars($order['recipient_name']) ?></div>
                            </div>
                        </div>
                        <div class="recipient-item">
                            <span class="recipient-icon"></span>
                            <div>
                                <div class="recipient-label">Số điện thoại</div>
                                <div class="recipient-value"><?= htmlspecialchars($order['recipient_phone']) ?></div>
                            </div>
                        </div>
                        <div class="recipient-item">
                            <span class="recipient-icon"></span>
                            <div>
                                <div class="recipient-label">Địa chỉ giao hàng</div>
                                <div class="recipient-value"><?= htmlspecialchars($order['ship_address']) ?></div>
                            </div>
                        </div>
                        <?php if (!empty($order['ship_note'])): ?>
                        <div class="recipient-item">
                            <span class="recipient-icon"></span>
                            <div>
                                <div class="recipient-label">Ghi chú</div>
                                <div class="recipient-value"><?= htmlspecialchars($order['ship_note']) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Chi tiết sản phẩm -->
            <div class="order-items-section">
                <div class="info-card">
                    <h2 class="card-title">Sản phẩm đã đặt (<?= count($order_items) ?>)</h2>
                    <div class="order-items-list">
                        <?php foreach ($order_items as $item): ?>
                            <div class="order-item">
                                <div class="item-image-wrapper"
                                         alt="<?= htmlspecialchars($item['product_name']) ?>"
                                         class="item-image">
                                </div>
                                <div class="item-info">
                                    <h3 class="item-name"><?= htmlspecialchars($item['product_name']) ?></h3>
                                    <div class="item-price-info">
                                        <span class="item-unit-price"><?= number_format($item['price'], 0, ',', '.') ?> đ</span>
                                        <span class="item-multiply">×</span>
                                        <span class="item-quantity"><?= $item['quantity'] ?></span>
                                    </div>
                                </div>
                                <div class="item-total-price">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <div class="order-summary">
                        <div class="summary-divider"></div>
                        <div class="summary-row summary-total">
                            <span>Tổng cộng:</span>
                            <span class="total-amount"><?= number_format($order['order_total'], 0, ',', '.') ?> đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="action-buttons">
            <a href="index.php?page=home" class="btn btn-primary">
                Tiếp tục mua sắm
            </a>
        </div>
    </div>
</div>
</body>
</html>