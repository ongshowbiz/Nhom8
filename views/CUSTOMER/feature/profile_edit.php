<?php
$ASSETS_URL = '/scm/public/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $ASSETS_URL ?>STYLES/profile_edit.css">
    <title>Document</title>
</head>
<body>
    <div class="profile-container">
    
    <h2 class="profile-title">✏️ Chỉnh sửa thông tin</h2>

    <?php if (!empty($msg)): ?>
        <div class="alert <?= $msg_type == 'success' ? 'alert-success' : 'alert-error' ?>">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=profile_edit" method="POST">
        <div class="form-group">
            <label class="form-label">Tên đăng nhập (Không thể sửa):</label>
            <input type="text" class="form-input input-disabled" 
                   value="<?= htmlspecialchars($customer['customer_name']) ?>" disabled>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label class="form-label">Họ và tên:</label>
                <input type="text" name="fullname" class="form-input"
                       value="<?= htmlspecialchars($customer['customer_fullname']) ?>" required>
            </div>
            <div class="form-col">
                <label class="form-label">Số điện thoại:</label>
                <input type="text" name="phone" class="form-input"
                       value="<?= htmlspecialchars($customer['customer_phone']) ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email:</label>
            <input type="email" name="email" class="form-input"
                   value="<?= htmlspecialchars($customer['customer_email']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Địa chỉ:</label>
            <input type="text" name="address" class="form-input"
                   value="<?= htmlspecialchars($customer['customer_address']) ?>" required>
        </div>

        <div class="form-actions">
            <a href="index.php?page=home" class="btn btn-back">
                ⬅️ Quay về
            </a>

            <div class="action-right">
                <button type="button" class="btn btn-toggle-pass" onclick="togglePasswordForm()">
                    🔒 Đổi mật khẩu
                </button>

                <button type="submit" name="btn_update_info" class="btn btn-save">
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </form>

    <div id="password-section">
        <h3 class="pass-title">🔑 Thay đổi mật khẩu</h3>
        <form action="index.php?page=profile_edit" method="POST">
            <div class="form-group">
                <label class="form-label">Mật khẩu cũ:</label>
                <input type="password" name="old_password" class="form-input" 
                       required placeholder="Nhập mật khẩu hiện tại">
            </div>
            
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label">Mật khẩu mới:</label>
                    <input type="password" name="new_password" class="form-input"
                           required placeholder="Mật khẩu mới (min 8 ký tự)">
                </div>
                <div class="form-col">
                    <label class="form-label">Nhập lại mật khẩu mới:</label>
                    <input type="password" name="confirm_password" class="form-input"
                           required placeholder="Xác nhận mật khẩu mới">
                </div>
            </div>

            <div class="pass-actions">
                <button type="button" class="btn btn-cancel" onclick="togglePasswordForm()">Hủy</button>
                <button type="submit" name="btn_change_pass" class="btn btn-confirm">
                    Xác nhận đổi mật khẩu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordForm() {
        var form = document.getElementById('password-section');
        if (form.style.display === 'block') {
            form.style.display = 'none';
        } else {
            form.style.display = 'block';
            form.scrollIntoView({behavior: "smooth"});
        }
    }
</script>
</body>
</html>
