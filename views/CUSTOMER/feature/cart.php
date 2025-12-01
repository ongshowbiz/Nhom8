<?php
$ASSETS_URL = '/scm/public/';
$message = isset($message) ? $message : '';
$messageType = isset($messageType) ? $messageType : 'info';
$selectedCount = isset($selectedCount) ? $selectedCount : 0;
$totalAmount = isset($totalAmount) ? $totalAmount : 0;
$cartItems = isset($cartItems) ? $cartItems : [];
foreach ($cartItems as &$item) {
    if (!isset($item['selected'])) $item['selected'] = 0;
}
unset($item);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/styles.CSS">
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/Giohang.CSS">
</head>
<body> 
    <?php include __DIR__ . '/../partial/header.php'; ?>
<div class="content-area">
    <div class="cart-container">
        <h1 class="cart-title">Giỏ hàng của Của Xì Trum 🍄</h1>

        <?php if (!empty($message)): ?>
            <div class="message <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <div class="message empty">
                <strong>Giỏ hàng của Xì Trum đang trống!</strong><br>
                <small>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.</small>
                <div style="margin-top: 20px;">
                    <a href="index.php?page=product_list" class="btn btn-primary">Tiếp tục mua sắm🍄</a>
                </div>
            </div>
        <?php else: ?>
            
            <div class="cart-controls">
                <div>
                    <button type="button" id="select-all" class="btn btn-primary">Chọn tất cả</button>
                    <button type="button" id="unselect-all" class="btn btn-secondary">Bỏ chọn tất cả</button>
                </div>
                <div class="selected-info">
                    Đã chọn: <strong><?= htmlspecialchars($selectedCount) ?></strong> / <?= count($cartItems) ?> sản phẩm
                </div>
            </div>

            <table class="cart-table">
                <thead>
                <tr>
                    <th width="50">Chọn</th>
                    <th>Sản phẩm</th>
                    <th width="150">Đơn giá</th>
                    <th width="100">Số lượng</th>
                    <th width="150">Thành tiền</th>
                    <th width="100">Thao tác</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cartItems as $index => $item): ?>
                    <tr>
                        <td class="checkbox-cell">
                            <input type="hidden" name="items[<?= $index ?>][c_item_id]" value="<?= $item['c_item_id'] ?>" form="cart-form">
                            <input type="hidden" name="items[<?= $index ?>][selected]" class="hidden-selected" value="<?= $item['selected'] ?>" form="cart-form">
                            <input type="checkbox" class="select-item-checkbox"
                                   <?= $item['selected'] ? 'checked' : '' ?> form="cart-form">
                        </td>
                        <td>
                            <div class="product-info">
                                <?php
                                    if (!empty($item['image_url'])) {
                                        $img_src = $ASSETS_URL . 'anhsp/' .$item['image_url'];
                                    } else {

                                        $img_src = $ASSETS_URL . 'anhsp/placeholder.jpg';
                                    }
                                ?>
                                <img src="<?= htmlspecialchars($img_src) ?>"
                                     alt="<?= htmlspecialchars($item['product_name']) ?>"
                                     class="product-image">
                                <div class="product-name"><?= htmlspecialchars($item['product_name']) ?></div>
                            </div>
                        </td>
                        <td><span class="price"><?= number_format($item['price'],0,',','.') ?> đ</span></td>
                        
                        <td class="quantity">
                            <div class="quantity-wrapper">
                                <form method="POST" action="index.php?page=update_cart" class="quantity-form">
                                    <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="quantity-input">
                                    <input type="hidden" name="c_item_id" value="<?= $item['c_item_id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-quantity">Cập nhật</button>
                                </form>
                            </div>
                        </td>

                        <td><span class="price"><?= number_format($item['price']*$item['quantity'],0,',','.') ?> đ</span></td>
                        
                        <td>
                            <form method="POST" action="index.php?page=delete_cart">
                                <input type="hidden" name="c_item_id" value="<?= $item['c_item_id'] ?>">
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <form id="cart-form" method="POST" action="index.php?page=cart" style="display: none;"></form>

            <div class="cart-summary">
                <div class="total-info">
                    <div class="selected-info">Tổng tiền (<?= htmlspecialchars($selectedCount) ?> sản phẩm):</div>
                    <div class="total-amount"><?= number_format($totalAmount, 0, ',', '.') ?> VNĐ</div>
                </div>
                <form method="POST" action="index.php?page=check_out">
                    <button type="submit" name="submit_checkout" class="btn btn-success">Đặt mua</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <script>
        document.querySelectorAll('.select-item-checkbox').forEach(function(checkbox){
            checkbox.addEventListener('change', function(){
                // Tìm input hidden "selected" nằm cùng cấp cha (td)
                let hidden = this.parentNode.querySelector('input.hidden-selected');
                hidden.value = this.checked ? 1 : 0;
                
                // Submit form tổng (form ảo ở dưới)
                document.getElementById('cart-form').submit();
            });
        });

        document.getElementById('select-all').addEventListener('click', function(){
            document.querySelectorAll('.select-item-checkbox').forEach(cb => {
                cb.checked = true;
                // Cập nhật value cho input hidden tương ứng
                cb.parentNode.querySelector('input.hidden-selected').value = 1;
            });
            document.getElementById('cart-form').submit();
        });

        document.getElementById('unselect-all').addEventListener('click', function(){
            document.querySelectorAll('.select-item-checkbox').forEach(cb => {
                cb.checked = false;
                // Cập nhật value cho input hidden tương ứng
                cb.parentNode.querySelector('input.hidden-selected').value = 0;
            });
            document.getElementById('cart-form').submit();
        });
    </script>
</div>
</body>
</html>