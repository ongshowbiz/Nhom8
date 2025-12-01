<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đơn Hàng - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/manage_orders.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="admin-container">
    <?php include __DIR__ . '/../partial/menu.php'; ?>
    <div class="content-area">
        <h2>Quản Lý Đơn Hàng</h2>
            <?php if (!empty($message)): ?>
                <div style="
                    padding: 15px;
                    margin-bottom: 20px;
                    border-radius: 5px;
                    font-weight: bold;
                    <?php 
                        // Kiểm tra: Nếu thông báo chứa chữ 'thất bại' hoặc 'lỗi' -> Màu đỏ. Ngược lại -> Màu xanh.
                        if (strpos($message, 'save_error') !== false ) {
                            echo 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;';
                        } else {
                            echo 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;';
                        }
                    ?>
                ">
                    <?= $message ?>
                </div>
            <?php endif; ?>

        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Tên Người Nhận</th>
                    <th>Số Điện Thoại Người Nhận</th>
                    <th>Địa Chỉ Nhận Hàng</th>
                    <th>Ghi Chú</th>
                    <th>Review</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            
            <tbody>
                <?php if(!empty($orders)): ?>
                    <?php foreach($orders as $order): ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= htmlspecialchars($order['customer_fullname']) ?></td>
                            <td><?= $order['order_date'] ?></td>
                            <td><?= number_format($order['order_total'] ?? 0) ?> VNĐ</td>
                            <td><?= htmlspecialchars($order['order_status']) ?></td>

                            <td><?= htmlspecialchars($order['recipient_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['recipient_phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['ship_address'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['ship_note'] ?? '') ?></td>
                            <td><?= htmlspecialchars($order['review'] ?? '') ?></td>
                            <td class="action-links">
                                <a href="<?= $PUBLIC_URL ?>index.php?page=order_detail&id=<?= $order['order_id'] ?>">Chi Tiết</a>
                                <a href="<?= $PUBLIC_URL ?>index.php?page=delete_order&id=<?= $order['order_id'] ?>" class = "delete">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">Chưa có đơn hàng nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>