<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sản Phẩm - Admin</title>

    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/submenu.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/manage_products.css">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
</head>
<body>

    <?php include __DIR__ . '/../partial/header.php'; ?>

    <div class="admin-container">

        <?php include __DIR__ . '/../partial/menu.php'; ?>

        <div class="content-area">
            <h2>Quản Lý Sản Phẩm</h2>
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
        <div class="main-columns">
            <!-- Form thêm sản phẩm -->
            <div class="form-container">
                <h3>Thêm Sản Phẩm Mới</h3>
                <form method="POST" action="/scm/public/index.php?page=add_product">

                    <div class="form-group">
                        <label for="product_name">Tên Sản Phẩm:</label>
                        <input type="text" id="product_name" name="product_name" required>
                    </div>

                    <div class="form-group">
                        <label for="brand">Thương Hiệu:</label>
                        <input type="text" id="brand" name="brand">
                    </div>

                    <div class="form-group">
                        <label for="product_type_id">Loại Sản Phẩm:</label>
                        <select id="product_type_id" name="product_type_id" required>
                            <option value="">-- Chọn loại --</option>
                            <?php foreach ($product_types as $type): ?>
                                <option value="<?= $type['product_type_id'] ?>"
                                    <?= $filter_type_id == $type['product_type_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class ="form-group">
                        <label for="product_size">kích cỡ:</label>
                        <input type="text" id= "product_size" name="product_size">
                    </div>

                    <div class="form-group">
                        <label for="unit">Đơn vị:</label>
                        <input type= "text" id="unit" name="unit"> 
                    </div>

                    <div class="form-group">
                        <label for="description">Mô Tả:</label>
                        <textarea id="description" name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="number" id="price" name="price" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Số Lượng:</label>
                        <input type="number" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Hình ảnh:</label> (vd: image.jpg or image.png)
                        <input type= "file" id="image_url" name="image_url">
                    </div>
                    <button type="submit" name="add_product" class="btn btn-primary">Thêm Sản Phẩm</button>
                </form>
            </div>


            <!-- Danh sách sản phẩm -->
            <div class="list-container">
                <h3>Danh Sách Sản Phẩm</h3>

                <div class="filter-container">
                    <form action="<?= $PUBLIC_URL ?>index.php" method="GET">
                        <input type="hidden" name="page" value="product">
                        <label for="filter_type_id">Lọc theo loại:</label>

                        <select name="type_id" id="filter_type_id">
                            <option value="0">-- Tất cả --</option>
                            <?php foreach ($product_types as $type): ?>
                                <option value="<?= $type['product_type_id'] ?>" 
                                        <?= $filter_type_id == $type['product_type_id'] ? 'selected' : '' ?>>
                                    
                                        <?= htmlspecialchars($type['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" class="btn-filter">Lọc</button>
                    </form>
                </div>

                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Thương Hiệu</th>
                            <th>Mô Tả</th>
                            <th>Loại Sản Phẩm</th>
                            <th>Kích Cỡ</th>
                            <th>Giá</th>
                            <th>Số Lượng</th>
                            <th>Đơn Vị</th>
                            <th>Link Ảnh</th>
                            <th>Hành Động</th> <!-- thêm cột Hành động -->
                        </tr>
                    </thead>
    
                    <tbody>
                        <?php if (!empty($product_arr)): ?>
                            <?php foreach ($product_arr as $row): ?>
                                <tr>
                                    <td><?= $row['product_id'] ?></td>
                                    <td><?= htmlspecialchars($row['product_name']) ?></td>
                                    <td><?= htmlspecialchars($row['brand'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['description'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['type_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($row['product_size'] ?? '') ?></td>
                                    <td><?= number_format($row['price']) ?> VNĐ</td>
                                    <td><?= $row['quantity'] ?></td>
                                    <td><?= htmlspecialchars($row['unit'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['image_url'] ?? '') ?></td>
                                    <td class="action-links">
                                        <a href="<?= $PUBLIC_URL ?>index.php?page=update_product&id=<?= $row['product_id'] ?>&p=<?= $current_page ?><?= $filter_type_id > 0 ? '&type_id='.$filter_type_id : '' ?>" class="edit">Sửa</a>
                                        <a href="<?= $PUBLIC_URL ?>index.php?page=delete_product&id=<?= $row['product_id'] ?>" class = "delete">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" style="text-align:center;">Chưa có sản phẩm nào</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- PHÂN TRANG -->
                    <div class="pagination">
                        <?php if ($total_pages > 1): ?>
                            <?php if ($current_page > 1): ?>
                                <a href="<?= $PUBLIC_URL ?>index.php?page=product&p=<?= $current_page - 1 ?><?= $filter_type_id > 0 ? '&type_id=' . $filter_type_id : '' ?>">
                                    &laquo; Trước
                                </a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="<?= $PUBLIC_URL ?>index.php?page=product&p=<?= $i ?><?= $filter_type_id > 0 ? '&type_id=' . $filter_type_id : '' ?>"
                                    class="<?= $i == $current_page ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <a href="<?= $PUBLIC_URL ?>index.php?page=product&p=<?= $current_page + 1 ?><?= $filter_type_id > 0 ? '&type_id=' . $filter_type_id : '' ?>">
                                    Sau &raquo;
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../partial/footer.php'; ?>
</body>
</html>