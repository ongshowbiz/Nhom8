<?php
$ASSETS_URL = '/scm/public/'; 
?>

<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="UTF-8">
        <title>ADMIN LOGIN</title>
        <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>css/TT.css">
    </head>
    <body> 
        <div class= "container"> 
            <div class = "form-box"> 
                 <img src="<?php echo $ASSETS_URL; ?>images/admin.png" alt="Logo" class="logo">
                
                <h2>ADMIN LOGIN</h2>

                <form action="/scm/public/index.php?page=login"method="post">
                    <input type="hidden" name="admin_login" value="1">

                    <div class=" input-group">
                        <label for="admin_name">Admin name:</label>
                        <input type="text" id="admin_name" name="admin_name" required> 
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required> 
                    </div>
                    <button type="submit" class="btn">Login</button> 

                    <p id="login-error-message" style="color: red; text-align: center; margin-top: 10px;">
                        <?php 
                        if (isset($msg) && !empty($msg)) {
                            echo htmlspecialchars($msg);
                        }
                        ?>
                    </p>
                </form>
            </div>
        </div>
    
    <script>
    window.onload = function() {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get('msg');
        const msgBox = document.getElementById('login-error-message');

        if (msg) {
            switch(msg){
                case 'login_failed':
                    msgBox.textContent = 'Sai tên đăng nhập hoặc mật khẩu';
                    break;
                case 'inactive':
                    msgBox.textContent = 'Tài khoản đã bị vô hiệu hóa';
                    break;
                case 'logout_ok':
                    msgBox.textContent = 'Đăng xuất thành công';
                    msgBox.style.color = 'green';
                    break;
            }
        }
    };
    </script>
</body>
</html>