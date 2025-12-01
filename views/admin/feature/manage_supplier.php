<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Nhà Cung Cấp - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/manage_suppliers.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="admin-container">
    <?php include __DIR__ . '/../partial/menu.php'; ?>
    <div class="content-area">
        <h2>Quản Lý Nhà Cung Ứng</h2>
        <?php if(!empty($message)): ?>
            <div class="message <?= strpos($message,'thất bại')!==false ? 'error':'success' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="main-columns">
            <div class="form-container">
                <h3>Thêm Nhà Cung Ứng Mới</h3>
                <form action="<?= $PUBLIC_URL ?>index.php?page=add_supplier" method="POST">
                    <div class="form-group">
                        <label>Tên Nhà Cung Ứng</label>
                        <input type="text" name="supplier_name" required>
                    </div>
                    <div class="form-group">
                        <label>Loại Sản Phẩm Phụ Trách</label>
                        <select name="product_type_id">
                            <option value="1">Đồ uống</option>
                            <option value="2">Đồ dùng</option>
                            <option value="3">Bánh kẹo</option>
                            <option value="4">Trái cây</option>
                            <option value="5">Thực phẩm</option>
                            <option value="6">Rau củ</option>
                            <option value="7">Gia vị</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Địa Chỉ</label>
                        <input type="text" name="supplier_address">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="supplier_email" required>
                    </div>
                    <div class="form-group">
                        <label>Điện Thoại</label>
                        <input type="tel" name="supplier_phone">
                    </div>
                    <div class="form-group">
                        <label>Điều Khoản Thanh Toán</label>
                        <input type="text" name="payment_terms">
                    </div>
                    <div class="form-group">
                    <label>Trạng Thái</label>
                    <select name="status">
                        <option value="active">Đang hoạt động</option>
                        <option value="paused">Tạm dừng</option>
                        <option value="terminated">Chấm dứt</option>
                    </select>
                </div>
                <button type="submit" name="add_supplier" class="btn btn-primary">Thêm Nhà Cung Ứng</button>
            </form>
        </div>

        <div class="list-container">
            <h3>Danh Sách Nhà Cung Ứng</h3>
            <table class="supplier-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Nhà Cung Ứng</th>
                        <th>Loại phụ trách</th>
                        <th>Địa Chỉ</th>
                        <th>Email</th>
                        <th>Điện Thoại</th>
                        <th>Điều Khoản Thanh Toán</th>
                        <th>Trạng Thái Hoạt Động</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(!empty($rows)): ?>
                        <?php foreach($rows as $supplier): ?>
                            <tr>
                                <td><?= $supplier['supplier_id'] ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_name']) ?></td>
                                <td><?= $supplier['product_type_id'] ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_address']) ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_email']) ?></td>
                                <td><?= htmlspecialchars($supplier['supplier_phone'] ?? 'Chưa có'); ?></td>
                                <td><?= htmlspecialchars($supplier['payment_terms']) ?></td>
                                <td><?= $supplier['status'] ?></td>

                                <td class="action-links">
                                    <a href="<?= $PUBLIC_URL ?>index.php?page=update_supplier&id=<?= $supplier['supplier_id'] ?>">Sửa</a>
                                    <a href="<?= $PUBLIC_URL ?>index.php?page=delete_supplier&id=<?= $supplier['supplier_id'] ?>"class = "delete">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center;">Chưa có nhà cung ứng nào</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>