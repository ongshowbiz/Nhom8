<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Đơn Hàng - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/order_detail.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="admin-container">
    <?php include __DIR__ . '/../partial/menu.php'; ?>
    <div class="content-area">
        <h2>Chi Tiết Đơn Hàng #<?= $order['order_id'] ?></h2>
        <p>Khách Hàng: <?= htmlspecialchars($order['customer_fullname']) ?></p>
        <p>Ngày Đặt: <?= $order['order_date'] ?></p>
        <p>Trạng Thái: <?= htmlspecialchars($order['order_status']) ?></p>

        <h3>Danh Sách Sản Phẩm</h3>
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>ID Sản Phẩm</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Đơn Giá</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($items)): ?>
                    <?php foreach($items as $item): ?>
                        <tr>
                            <td><?= $item['product_id'] ?></td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'] ?? 0) ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align:center;">Chưa có sản phẩm nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <form method="POST" action="<?= $PUBLIC_URL ?>index.php?page=update_order_status">
            <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
            <label for="order_status">Cập nhật trạng thái:</label>
            <select name="order_status" id="order_status">
                <option value="pending" <?= $order['order_status']=='pending' ? 'selected' : '' ?>>Đang xử lý</option>
                <option value="processing" <?= $order['order_status']=='processing' ? 'selected' : '' ?>>Đang giao</option>
                <option value="completed" <?= $order['order_status']=='completed' ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="cancelled" <?= $order['order_status']=='cancelled' ? 'selected' : '' ?>>Hủy</option>
            </select>
            
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
</div>
<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>
