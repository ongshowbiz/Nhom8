<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập Nhật Thông Tin Nhà Cung Ứng - Admin</title>
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/xoasua.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>

<body>
<?php include __DIR__ . '/../partial/header.php'; ?>
<div class="main-body-wrapper">
    <?php include __DIR__ . '/../partial/menu.php'; ?>
    <div class="main-columns">
        <h2>Chỉnh Sửa Thông Tin Nhà Cung Ứng #<?= $supplier['supplier_id'] ?></h2>
        <form class="form-container" action="<?= $PUBLIC_URL ?>index.php?page=update_supplier&id=<?= $supplier['supplier_id'] ?>" method="POST">
            <input type="hidden" name="supplier_id" value="<?= $supplier['supplier_id'] ?>">

            <div class="form-group">    
                <label>Tên Nhà Cung Cấp</label>
                <input type="text" name="supplier_name" value="<?= htmlspecialchars($supplier['supplier_name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Loại Sản Phẩm Phụ Trách</label>
                <select name="product_type_id">
                    <option value="1" <?= $supplier['product_type_id']==1?'selected':'' ?>>Đồ uống</option>
                    <option value="2" <?= $supplier['product_type_id']==2?'selected':'' ?>>Đồ dùng</option>
                    <option value="3" <?= $supplier['product_type_id']==3?'selected':'' ?>>Bánh kẹo</option>
                    <option value="4" <?= $supplier['product_type_id']==4?'selected':'' ?>>Trái cây</option>
                    <option value="5" <?= $supplier['product_type_id']==5?'selected':'' ?>>Thực phẩm</option>
                    <option value="6" <?= $supplier['product_type_id']==6?'selected':'' ?>>Rau củ</option>
                    <option value="7" <?= $supplier['product_type_id']==7?'selected':'' ?>>Gia vị</option>
                </select>
            </div>

            <div class="form-group">
                <label>Địa Chỉ</label>
                <input type="text" name="supplier_address" value="<?= htmlspecialchars($supplier['supplier_address']) ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="supplier_email" value="<?= htmlspecialchars($supplier['supplier_email']) ?>" required>
            </div>

            <div class="form-group">
                <label>Điện Thoại</label>
                <input type="text" name="supplier_phone" value="<?= htmlspecialchars($supplier['supplier_phone'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Điều Khoản Thanh Toán</label>
                <input type="text" name="payment_terms" value="<?= htmlspecialchars($supplier['payment_terms']) ?>">
            </div>

            <div class="form-group">
                <label>Trạng Thái</label>
                <select name="status">
                    <option value="active" <?= $supplier['status']=='active' ? 'selected':'' ?>>Đang hoạt động</option>
                    <option value="paused" <?= $supplier['status']=='paused' ? 'selected':'' ?>>Tạm dừng</option>
                    <option value="terminated" <?= $supplier['status']=='terminated' ? 'selected':'' ?>>Chấm dứt</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" name="update_supplier" class="btn btn-primary">Cập Nhật</button>
                <a href="<?= $PUBLIC_URL ?>index.php?page=suppliers" class="btn btn-secondary">Hủy</a>
            </div> 
        </form>
    </div>
</div>
<?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>