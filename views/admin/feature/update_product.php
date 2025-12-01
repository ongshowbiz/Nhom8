<?php
$ASSETS_URL = '/scm/public/';
$PUBLIC_URL = '/scm/public/';
?>

<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>CẬP NHẬT SẢN PHẨM</title>
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/styles.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/submenu.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/xoasua.css">
            <link rel="stylesheet" href="<?= $ASSETS_URL ?>css/footer.css">
    </head>

    <body>
        <?php
        include __DIR__ . '/../partial/header.php';
        ?>

        <div class="main-body-wrapper">
            <?php
            include __DIR__ . '/../partial/menu.php';
            ?>

            <div class="main-columns">
                <div class="form-container">
                    <h2>CẬP NHẬT SẢN PHẨM</h2>
                    <form action="/scm/public/index.php?page=update_product" method="POST">
                        <input type="hidden" name="update_product" value="1">
                        <input type="hidden" name="product_id" value="<?= $product_to_edit['product_id'] ?>">
                        <input type="hidden" name="p" value="<?= isset($current_page) ? $current_page : 1 ?>">
                        <input type="hidden" name="type_id" value="<?= isset($filter_type_id) ? $filter_type_id : 0 ?>">

                        <div class="form-group">
                            <label>Tên sản phẩm:</label><br>
                            <input type="text" name="product_name" value="<?= htmlspecialchars($product_to_edit['product_name']) ?>" required><br><br>
                        </div>

                        <div class="form-group">
                        <label>Thương hiệu:</label><br>
                        <input type="text" name="brand" value="<?= htmlspecialchars($product_to_edit['brand']) ?>"><br><br>
                        </div>

                        <div class="form-group">
                        <label>Loại sản phẩm:</label><br>
                        <select name="product_type_id" required>
                            <?php foreach($product_types as $type): ?>
                                <option value="<?= $type['product_type_id'] ?>" 
                                    <?= $type['product_type_id'] == $product_to_edit['product_type_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($type['type_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br><br>
                        </div>

                    <div class ="form-group">
                        <label for="product_size">kích cỡ:</label>
                        <input type="text" name="product_size" value="<?= htmlspecialchars($product_to_edit['product_size']) ?>">
                    </div>

                    <div class="form-group">
                        <label for="unit">Đơn vị:</label>
                        <input type= "text" id="unit" name="unit" value="<?= htmlspecialchars($product_to_edit['unit']) ?>"> 
                    </div>

                    <div class="form-group">
                        <label for="description">Mô Tả:</label>
                        <textarea id="description" name="description"><?= htmlspecialchars($product_to_edit['description']) ?></textarea>
                    </div>


                    <div class="form-group">
                        <label for="price">Giá:</label>
                        <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product_to_edit['price']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Số Lượng:</label>
                        <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($product_to_edit['quantity']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="image_url">Hình ảnh:</label> (vd: image.jpg or image.png)
                        <input type= "text" id="image_url" name="image_url" value="<?= htmlspecialchars($product_to_edit['image_url']) ?>">
                    </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <a href="<?= $PUBLIC_URL ?>index.php?page=product&p=<?= isset($current_page) ? $current_page : 1 ?>
                            <?= (isset($filter_type_id) && $filter_type_id > 0) ? '&type_id='.$filter_type_id : '' ?>" 
                            class="btn btn-secondary">Hủy
                        </a>
                    </form>
                </div>

            </div>
        </div>
    <?php include __DIR__ . '/../partial/footer.php'; ?>
    </body>
</html>