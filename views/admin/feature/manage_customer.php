<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
function time_elapsed_string($datetime, $full = false) {
    if (empty($datetime)) return "Chưa xác định";
    
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    // Nếu quá 1 năm -> Trả về số năm (để cảnh báo)
    if ($diff->y > 0) {
        return "<span style='color: red; font-weight: bold;'>{$diff->y} năm trước</span>";
    }
    // Nếu quá 1 tháng
    if ($diff->m > 0) {
        return $diff->m . " tháng trước";
    }
    // Nếu quá 1 ngày
    if ($diff->d > 0) {
        return $diff->d . " ngày trước";
    }
    // Nếu trong ngày
    if ($diff->h > 0) return $diff->h . " giờ trước";
    if ($diff->i > 0) return $diff->i . " phút trước";
    return "Vừa xong";
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Khách Hàng - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/manage_customers.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="admin-container">
    <?php include __DIR__ . '/../partial/menu.php'; ?>

    <div class="content-area">
        <h2>Quản Lý Khách Hàng</h2>

        <?php if(!empty($message)): ?>
            <div class="message <?= strpos($message,'thất bại')!==false ? 'error':'success' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <table class="customer-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ Tên</th>
                    <th>Email</th>
                    <th>Điện Thoại</th>
                    <th>Địa Chỉ</th>
                    <th>Hoạt động cuối</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if(!empty($customer)): ?>
                    <?php foreach($customer as $row): ?>
                        <?php 
                            // Logic: Lấy ngày đăng nhập cuối, nếu không có thì lấy ngày tạo
                            $last_active_date = !empty($row['last_login']) ? $row['last_login'] : $row['created_at'];
                        ?>
                        <tr>
                            <td><?= $row['customer_id'] ?></td>
                            <td><?= htmlspecialchars($row['customer_fullname']) ?></td>
                            <td><?= htmlspecialchars($row['customer_email']) ?></td>
                            <td><?= htmlspecialchars($row['customer_phone']) ?></td>
                            <td><?= htmlspecialchars($row['customer_address']) ?></td>
                            <td class="col-date">
                                <?= time_elapsed_string($last_active_date) ?>
                                <br>
                                <small style="color: #999;">(<?= date('d/m/Y', strtotime($last_active_date)) ?>)</small>
                            </td>
                            <td><?= htmlspecialchars($row['status']) ?></td>

                            <td class="action-links">
                                <a href="<?= $PUBLIC_URL ?>index.php?page=delete_customer&id=<?= $row['customer_id'] ?>" class="delete" >Xóa </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">Chưa có khách hàng nào</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>

<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>