<?php if (!isset($msg_error)) $msg_error = ""; ?>
<?php
$ASSETS_URL = '/scm/public/'; 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register Page</title>
        <link rel="stylesheet" href="<?php echo $ASSETS_URL ?>STYLES/TT.css">
    </head>
    <body>
        <div class="container">
            <div class="form-box">
                <img src="<?php echo $ASSETS_URL ?>images/customer.png" alt="Logo" class="logo">
                <h2>Register</h2>
                <form id="registerForm" action="/scm/views/CUSTOMER/index.php?page=register" method= "post">
                                    
                    <div class="input-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="customer_fullname">Full Name:</label>
                        <input type="text" id="customer_fullname" name="customer_fullname" required>
                    </div>

                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="input-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel"  id="phone" name="phone" required>
                    </div>

                    <div class="input-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <div id="passwordStrength" class="password-strength"></div> <!-- Hiển thị độ mạnh của mật khẩu -->
                    </div>

                    <div class="input-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm-password" required> <!-- Xác nhận mật khẩu -->
                    </div>

                    <p id="register-error-message" class="error-message">
                        <?php echo htmlspecialchars($msg_error); ?>
                    </p>

                    <button type="submit" name="submit_register" class="btn">Register</button>
                    <p class="login-link">Already have an account? <a href="Login2.0.php">Login here</a></p>
                </form>
            </div>
        </div>
         <script>
            // Kiểm tra độ mạnh của mật khẩu
            document.getElementById('password').addEventListener('input', function() { //function() = hàm chạy khi sự kiện xảy ra
                const password = this.value;
                const strengthDiv = document.getElementById('passwordStrength');
                
                if (password.length === 0) {
                    strengthDiv.textContent = '';
                    return;
                }
                
                let strength = 0;
                let feedback = [];
                
                // Kiểm tra các tiêu chí
                if (password.length >= 8) strength++;
                else feedback.push('at least 8 characters');
                
                if (/[a-z]/.test(password)) strength++;
                else feedback.push('lowercase letter');
                
                if (/[A-Z]/.test(password)) strength++;
                else feedback.push('uppercase letter');
                
                if (/[0-9]/.test(password)) strength++;
                else feedback.push('number');
                
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                else feedback.push('special character');
                
                // Hiển thị độ mạnh
                if (strength < 2) {
                    strengthDiv.className = 'password-strength strength-weak';
                    strengthDiv.textContent = 'Weak - Need: ' + feedback.slice(0, 2).join(', ');
                } else if (strength < 4) {
                    strengthDiv.className = 'password-strength strength-medium';
                    strengthDiv.textContent = 'Medium - Consider adding: ' + feedback.slice(0, 1).join(', ');
                } else {
                    strengthDiv.className = 'password-strength strength-strong';
                    strengthDiv.textContent = 'Strong password!';
                }
            });
            
            // Kiểm tra khớp mật khẩu
            document.getElementById('confirm-password').addEventListener('input', function() {
                const password = document.getElementById('password').value;
                const confirmPassword = this.value;
                
                if (confirmPassword && password !== confirmPassword) {
                    this.style.borderColor = '#e74c3c';
                    this.setCustomValidity('Mật khẩu không khớp');
                } else {
                    this.style.borderColor = '#e1e1e1';
                    this.setCustomValidity('');
                }
            });
            
           // --- SỬA LẠI SCRIPT XỬ LÝ SUBMIT ---

            const registerForm = document.getElementById('registerForm');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('confirm-password');
            const errorElement = document.getElementById('register-error-message');

            // Kiểm tra khớp mật khẩu khi gõ
            confirmPasswordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const confirmPassword = this.value;
                
                if (confirmPassword && password !== confirmPassword) {
                    this.style.borderColor = '#e74c3c';
                    this.setCustomValidity('Mật khẩu không khớp'); // Dùng validation API
                } else {
                    this.style.borderColor = '#e1e1e1';
                    this.setCustomValidity(''); // Xóa lỗi
                }
            });
            
            // Xử lý form submit
            registerForm.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (password !== confirmPassword) {
                    // Ngăn form submit nếu mật khẩu không khớp
                    e.preventDefault(); 
                    
                    if(errorElement) {
                        errorElement.textContent = 'Mật khẩu xác nhận không khớp!';
                    } else {
                        alert('Mật khẩu xác nhận không khớp!');
                    }
                    confirmPasswordInput.focus();
                    return;
                }

                // Nếu mật khẩu khớp, không làm gì cả (không preventDefault)
                // Form sẽ được submit lên server
                // Xóa alert demo
                // alert('Registration successful! (This is a demo)');
            });
        </script>
    </body>
</html>