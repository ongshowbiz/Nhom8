<?php
require_once __DIR__ . '/../../connect/database.php';
require_once __DIR__ . '/../../connect/cookie_customer.php';
require_once __DIR__ . '/../../models/customer/customer.php';

class CustomerController {
    private $model;
    private $PUBLIC_URL;
    private $ASSETS_URL;

    public function __construct() {
        global $connect;
        $this->model = new dbcustomer($connect);

        $this->PUBLIC_URL = '/scm/public/';
        $this->ASSETS_URL = '/scm/public/';

        if(session_status() === PHP_SESSION_NONE) session_start();
    }

    public function home() {    
        $product_types = $this->model->getProductTypes();
        $home_product_groups = []; 

        if (!empty($product_types)) {
            foreach( $product_types as $type ) {
                $products = $this->model->getProductsByType($type['product_type_id'], 0 , 4);
                $home_product_groups[] = [
                        'type_id' => $type['product_type_id'],
                        'type_name' => $type['type_name'],
                        'products' => $products
                ];
            }
        }
        include __DIR__ . '/../../views/CUSTOMER/dashboard.php';
    }

    public function intro(){
        include __DIR__ . '/../../views/CUSTOMER/pages/about.php';
    }

    public function contact() {
        include __DIR__ . '/../../views/CUSTOMER/pages/contact.php';
    }

    public function register() {
        $msg_error = "";
        if (isset($_POST['submit_register'])) {
            $name = trim($_POST['username']);
            $fullname=trim($_POST['customer_fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);
            $password = $_POST['password'];
            $confirm_pass = $_POST['confirm-password'];

            if (empty($name) || empty($fullname) || empty($email) || empty($phone) || empty($address) || empty($password)) {
                $msg_error = 'Vui lòng điền đầy đủ thông tin.';
            } 
            elseif ($password !== $confirm_pass) {
                $msg_error = 'Mật khẩu không khớp.';
            } 
            elseif (strlen($password) < 8) {
                $msg_error = 'Mật khẩu phải có ít nhất 8 ký tự.'; 
            } 
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg_error = 'Email không hợp lệ.';
            } 
            else {
                $kq = $this->model->registerCustomer($name, $fullname, $email, $phone, $address, $password);

                if ($kq === true) {
                    header("Location: /scm/views/CUSTOMER/index.php?page=login&success=1");
                    exit;
                } 
                else {
                    $msg_error = $kq; 
                }
            }
        }
        include __DIR__ . '/../../views/CUSTOMER/Register2.0.php';
    }

    public function login() {
        $msg_error = "";

        if (!empty($_SESSION['customer_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        if (isset($_POST['submit_login'])) {
            $customer_name = trim($_POST['username']);
            $password = $_POST['password'];
            $kq = $this->model->loginCustomer($customer_name, $password);

            if (is_array($kq)) {
                session_regenerate_id(true);
                $_SESSION['customer_id'] = $kq['customer_id'];
                $_SESSION['customer_name'] = $kq['customer_name'];
                $_SESSION['customer_fullname'] = $kq['customer_fullname'];

                if (isset($_POST['remember-me'])) {
                    setcookie('remember_customer_id', $kq['customer_id'], time() + (30*24*60*60), "/");
                } 
                else {
                    setcookie('remember_customer_id', '', time() - 3600, "/");
                }

                header("Location: index.php?page=home"); 
                exit;
            } 
            else {
                $msg_error = $kq;
            }
        }
        include __DIR__ . '/../../views/CUSTOMER/Login2.0.php';
    }

    public function logout() {
        $this->model->logoutCustomer(); 
        setcookie('remember_customer_id', '', time() - 3600, "/");
        header("Location: index.php?page=home");
        exit;
    }

    public function product_type() {
        $product_types = $this->model->getProductTypes();
        foreach ($product_types as & $type) {
        $type['total_products'] = $this->model->countProductsbyType($type['product_type_id']);
        }
        include __DIR__ . '/../../views/CUSTOMER/feature/Product_type.php';
    }
    public function productDetail() {
        $product_id = (int)($_GET['id'] ?? 0);
        if ($product_id <= 0) {
            header("Location: index.php?page=product_list");
            exit;
        }
        
        $product = $this->model->getProductDetailById($product_id);
        if (!$product) {
            echo "<h1>404 - Không tìm thấy sản phẩm</h1>";
            exit;
        }
        $related_products = $this->model->getProductsByType($product['product_type_id'], 0, 4); 
        include __DIR__ . '/../../views/CUSTOMER/feature/Product_detail.php';
    }

    public function product_list() {
        // --- Lấy các tham số lọc từ URL ---
        // (MỚI: Chuyển $filter_brand và $filter_price thành MẢNG)
        $filter_type_id = (int)($_GET['type_id'] ?? 0);
        $filter_brands = (array)($_GET['brand'] ?? []); // <-- Đọc là một mảng
        $filter_prices = (array)($_GET['price'] ?? []); // <-- Đọc là một mảng

        // --- Phân trang ---
        $products_per_page = 12;
        $current_page = (int)($_GET['p'] ?? 1);
        if ($current_page < 1) $current_page = 1;
        $offset = ($current_page - 1) * $products_per_page;

        // --- Lấy dữ liệu cho View ---
        $product_types = $this->model->getProductTypes();
        $brands = $this->model->getBrands();
        $price_ranges = [
            'p1' => 'Dưới 100000',
            'p2' => 'Giữa 100000 - 200000 ',
            'p3' => 'Trên 200000'
        ];

        // Lấy tổng số sản phẩm (MỚI: Truyền mảng vào Model)
        $total_products = $this->model->countProducts($filter_type_id, $filter_brands, $filter_prices);
        $total_pages = ceil($total_products / $products_per_page);
        
        // Lấy sản phẩm (MỚI: Truyền mảng vào Model)
        $products = $this->model->getProducts($filter_type_id, $filter_brands, $filter_prices, $products_per_page, $offset);

        // --- Thông báo ---
        $message = '';
        if (isset($_GET['msg'])) {
            if ($_GET['msg'] == 'add_ok') $message = 'Đã thêm sản phẩm vào giỏ hàng!';
        }

        include __DIR__ . '/../../views/CUSTOMER/feature/Product_list.php';
    }

    public function profile_edit() {
        if (!isset($_SESSION['customer_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $customer = $this->model->getCustomerDetails($_SESSION['customer_id']);
        $msg = "";
        $msg_type = ""; // success hoặc error

        // Xử lý: Cập nhật thông tin chung
        if (isset($_POST['btn_update_info'])) {
            $fullname = trim($_POST['fullname']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            $kq = $this->model->updateInfo($_SESSION['customer_id'], $fullname, $email, $phone, $address);
            if ($kq === true) {
                $msg = "Cập nhật thông tin thành công!";
                $msg_type = "success";
                // Cập nhật lại session hiển thị
                $_SESSION['customer_fullname'] = $fullname;
                // Load lại thông tin mới để hiển thị ra form
                $customer = $this->model->getCustomerDetails($_SESSION['customer_id']);
            } else {
                $msg = $kq;
                $msg_type = "error";
            }
        }

        // Xử lý: Đổi mật khẩu
        if (isset($_POST['btn_change_pass'])) {
            $old_pass = $_POST['old_password'];
            $new_pass = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];

            if ($new_pass !== $confirm_pass) {
                $msg = "Mật khẩu mới nhập lại không khớp.";
                $msg_type = "error";
            } elseif (strlen($new_pass) < 8) {
                $msg = "Mật khẩu mới phải từ 8 ký tự trở lên.";
                $msg_type = "error";
            } else {
                $kq = $this->model->changePassword($_SESSION['customer_id'], $old_pass, $new_pass);
                if ($kq === true) {
                    $msg = "Đổi mật khẩu thành công!";
                    $msg_type = "success";
                } else {
                    $msg = $kq;
                    $msg_type = "error";
                }
            }
        }

        include __DIR__ . '/../../views/CUSTOMER/feature/profile_edit.php';
    }

    public function add_to_cart() {
        if(!isset($_SESSION['customer_id'])){
            header("Location: index.php?page=login");
            exit;
        }

        $product_id = (int)($_POST['product_id'] ?? 0);
        $quantity   = (int)($_POST['quantity'] ?? 1);
        
        // Lấy URL hiện tại được gửi từ form (nếu có)
        $redirect_url = $_POST['redirect_url'] ?? 'index.php?page=product_list';

        if (isset($_POST['buy_now'])) {
            $redirect_url = 'index.php?page=cart';
        }
        
        if($product_id <= 0){
            // Nếu lỗi thì quay lại trang cũ
            header("Location: " . $redirect_url);
            exit;
        }

        $this->model->addCart($_SESSION['customer_id'], $product_id, $quantity);
        
        // --- ĐOẠN CODE SỬA ĐỔI ---
        // Kiểm tra xem trong URL đã có tham số ? chưa để nối chuỗi cho đúng
        if (strpos($redirect_url, '?') !== false) {
            $redirect_url .= '&msg=add_ok';
        } else {
            $redirect_url .= '?msg=add_ok';
        }

        // Chuyển hướng về lại trang vừa đứng (Product list) thay vì trang Cart
        header("Location: " . $redirect_url);
        exit;
    }

    public function cart(){
        if(!isset($_SESSION['customer_id'])){
            header("Location: index.php?page=login");
            exit;
        }

        $customer_id = $_SESSION['customer_id'];
        if (!isset($_SESSION['cart_selected'])) {
            $_SESSION['cart_selected'] = [];
        }

        if (isset($_POST['items']) && is_array($_POST['items'])) {
            foreach ($_POST['items'] as $item) {
                $c_item_id = (int)($item['c_item_id'] ?? 0);
                $selected = isset($item['selected']) ? (int)$item['selected'] : 0;

                if ($selected) {
                    if (!in_array($c_item_id, $_SESSION['cart_selected'])) {
                        $_SESSION['cart_selected'][] = $c_item_id;
                    }
                } else {
                    $_SESSION['cart_selected'] = array_diff($_SESSION['cart_selected'], [$c_item_id]);
                }
            }
            header("Location: index.php?page=cart");
            exit;
        }

        $cartItems = $this->model->getCartItems($customer_id);
        foreach($cartItems as &$item){
            $item['selected'] = in_array($item['c_item_id'], $_SESSION['cart_selected']) ? 1 : 0;
        }
        unset($item);

        $totalAmount = 0;
        $selectedCount = 0;
        foreach($cartItems as $item){
            if($item['selected']){
                $totalAmount += $item['price'] * $item['quantity'];
                $selectedCount++;
            }
        }
        include __DIR__ . '/../../views/CUSTOMER/feature/cart.php';
    }

    public function update_cart(){
        if(!isset($_SESSION['customer_id'])){
            header("Location: index.php?page=login");
            exit;
        }
        $c_item_id = (int)($_POST['c_item_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);
        if($c_item_id > 0 && $quantity > 0){
            $this->model->updateCart($c_item_id, $quantity);
        }
        header("Location: index.php?page=cart");
        exit;
    }

    public function delete_cart(){
        if(!isset($_SESSION['customer_id'])){
            header("Location: index.php?page=login");
            exit;
        }
        $c_item_id = (int)$_POST['c_item_id'];
        $this->model->deleteCart($c_item_id);

        if(isset($_SESSION['cart_selected'])){
            $_SESSION['cart_selected'] = array_diff($_SESSION['cart_selected'], [$c_item_id]);
        }

        header("Location: index.php?page=cart");
        exit;
    }
public function check_out(){
    if (!isset($_SESSION['customer_id'])) {
        header("Location: index.php?page=login");
        exit;
    }
    $customer_info = $this->model->getCustomerDetails($_SESSION['customer_id']);
    $name = $customer_info['customer_fullname'] ?? '';
    $phone = $customer_info['customer_phone'] ?? '';
    $address = $customer_info['customer_address'] ?? '';
    $note = '';
    $msg_error = '';

    // Xử lý khi người dùng bấm nút đặt mua
    if (isset($_POST['submit_checkout'])) {
    //lấy các sản phẩm đã chọn
        $selected_items = $_SESSION['cart_selected'] ?? [];
    //nếu chưa có sản phẩm nào được chọn thì quay lại giỏ
    if (empty($selected_items)) {
        header("Location: index.php?page=cart"); 
        exit; 
    }
    //thông tin lưu vào order chứ  lưu vào thông tin của customer
        $name = trim($_POST['recipient_name'] ?? '');
        $phone = trim($_POST['recipient_phone'] ?? '');
        $address = trim($_POST['ship_address'] ?? '');
        $note = trim($_POST['ship_note'] ?? '');
            //điền thiếu thông tin
        if (empty($name) || empty($phone) || empty($address)) {
            $msg_error = 'Vui lòng điền đầy đủ thông tin người nhận.';
        } else {
        $result_id = $this->model->checkOut($_SESSION['customer_id'], $name, $phone, $address, $note, $selected_items);
        if (is_numeric($result_id) && $result_id > 0) {
        $_SESSION['cart_selected'] = []; 
    // Chuyển trang với ID chính xác vừa nhận được
        header("Location: index.php?page=order_success&order_id=$result_id");
        exit;
} else {
    // Nếu không phải số thì nó là thông báo lỗi
    $msg_error = $result_id;
}
        }
    }
    // hiển thị ra View
    $selected_items = $_SESSION['cart_selected'] ?? [];
    $cartItems = $this->model->getCartItems($_SESSION['customer_id']);
    $selectedProducts = [];
    
    // Lọc ra các sản phẩm được chọn để tính tiền
    foreach ($cartItems as $item) {
        if (in_array($item['c_item_id'], $selected_items)) {
            $selectedProducts[] = $item;
        }
    }
    
    $totalAmount = 0;
    foreach ($selectedProducts as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
    
    include __DIR__ . '/../../views/CUSTOMER/feature/checkout.php';
}

// Trang đặt hàng thành công
    public function order_success() {
        if (!isset($_SESSION['customer_id'])) {
            header("Location: index.php?page=login");
            exit;
        }
    
        $order_id = (int)($_GET['order_id'] ?? 0);
        if ($order_id <= 0) {
            header("Location: index.php?page=home");
            exit;
        }

        $order = $this->model->getOrderById($order_id);
        if (!$order || $order['customer_id'] != $_SESSION['customer_id']) {
            header("Location: index.php?page=home");
            exit;
        }

        $order_items = $this->model->getOrderItems($order_id);
        include __DIR__ . '/../../views/CUSTOMER/feature/order_success.php';
    }   
    // Lịch sử đơn hàng
    public function order_list() {
        if (!isset($_SESSION['customer_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $orders = $this->model->getCustomerOrders($_SESSION['customer_id']);
        include __DIR__ . '/../../views/CUSTOMER/feature/order_list.php';
    }

    // Chi tiết đơn hàng
    public function order_detail() {
        if (!isset($_SESSION['customer_id'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $order_id = (int)($_GET['id'] ?? 0);
        if ($order_id <= 0) {
            header("Location: index.php?page=listOrders");
            exit;
        }

        $order = $this->model->getOrderById($order_id);
        if (!$order || $order['customer_id'] != $_SESSION['customer_id']) {
            header("Location: index.php?page=listOrders");
            exit;
        }

        $order_items = $this->model->getOrderItems($order_id);
        include __DIR__ . '/../../views/CUSTOMER/feature/order_detail.php';
    }
}
?>