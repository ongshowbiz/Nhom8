<?php
$ASSETS_URL = '/scm/public/'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/TT.css">
    </head>
    <body> 
        <div class= "container">
            <div class = "form-box">
                <img src="<?php echo $ASSETS_URL ?>images/customer.png" alt="Logo" class="logo">
                <h2>Login</h2>

                <form action="/scm/views/CUSTOMER/index.php?page=login"method="post">
                    <div class=" input-group">
                        <label for="username">User name:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required> 
                    </div>
                    <button type="submit" name = "submit_login"class="btn">Login</button> <!-- Nút đăng nhập -->

                    <p id="login-error-message" style="color: red; text-align: center; margin-top: 10px;">

                        <?php 
                        // In thông báo lỗi (nếu có) do controller truyền sang
                        if (isset($msg_error) && !empty($msg_error)) {
                            echo htmlspecialchars($msg_error);
                        }
                        ?>

                    </p>

                    <div class="remember-me">
                        <label for="remember-me">
                        <input type="checkbox" id="remember-me" name="remember-me" value=1> Remember Me
                        </label>
                    </div>

                    <p class="register-link">Don't have an account? <a href="Register2.0.php">Register here</a>
                    </p> <!-- Liên kết đến trang đăng ký -->
                </form>
                <form action="/scm/views/CUSTOMER/index.php?page=home" method="get">
                    <button type="submit"  class="btn btn-home">Về Làng 🏠</button> <!-- Nút trở về trang chủ -->
                </form>
            </div>
        </div>
    <script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const success = urlParams.get('success');
        const error = urlParams.get('error');

        const errorMessageElement = document.getElementById('login-error-message');
        const phpError = errorMessageElement ? errorMessageElement.textContent.trim() : '';

        if (phpError) return;

        if (success === '1') {
            errorMessageElement.style.color = 'green';
            errorMessageElement.textContent = 'Đăng ký thành công! Vui lòng đăng nhập.';
        } else if (error) {
            if (error === 'wrong_password') {
                errorMessageElement.textContent = 'Sai mật khẩu, vui lòng thử lại.';
            } else if (error === 'user_not_found') {
                errorMessageElement.textContent = 'Tài khoản không tồn tại.';
            }
        }
    };
    </script>
    </body>
</html>