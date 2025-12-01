<?php
require_once __DIR__ . '/../../connect/database.php';
require_once __DIR__ . '/../../models/admin/admin.php';

class AdminController {
    private $model;
    private $PUBLIC_URL = '/scm/public/';
    private $ASSETS_URL = '/scm/public/assets/';

    public function __construct() {
        global $connect;
        $this->model = new dbadmin($connect);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function home() {
        include __DIR__ . '/../../views/admin/dashboard.php';
    }

    public function dashboard() {
        include __DIR__ . '/../../views/admin/dashboard.php';
    }
    
    public function contact() {
        include __DIR__ . '/../../views/admin/pages/contact.php';
    }


    public function login() {
        if (!empty($_SESSION['admin_id'])) {
            header("Location: index.php?page=home");
            exit;
        }

        if (isset($_POST['admin_login'])) {
            $admin_name = trim($_POST['admin_name']);
            $password = $_POST['password'];
            $kq = $this->model->loginAdmin($admin_name, $password);

            if (is_array($kq)) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $kq['admin_id'];
                $_SESSION['admin_name'] = $kq['admin_name'];
                $_SESSION['is_admin'] = true;

                header("Location: index.php?page=home");
                exit;
            } 
            else {
                $msg = $kq;
                include __DIR__ . '/../../views/admin/login.php';
                exit;
            }
        }
        include __DIR__ . '/../../views/admin/login.php';
    }

    public function logout() {              
        $this->model->logoutAdmin();      
        header("Location: index.php?page=login");  
        exit;
    }

    public function checkAdmin() {
        if(empty($_SESSION['admin_id']) || empty($_SESSION['is_admin'])){
            header("Location: index.php?page=login");
            exit;
        }
    }
    
    public function manageProducts() {
        $filter_type_id = (int)($_GET['type_id'] ?? 0);
        $current_page = (int)($_GET['p'] ?? 1);

        if ($current_page < 1) $current_page = 1;

        $per_page = 10;
        $offset = ($current_page - 1) * $per_page;
        // 2. Lấy danh sách loại sản phẩm
        $product_types = $this->model->getProductTypes();
        $product_types = $product_types ? $product_types->fetch_all(MYSQLI_ASSOC) : [];
        
        // 3. Tính toán phân trang
        $total_products = $this->model->countProducts($filter_type_id);
        $total_pages = ($per_page > 0) ? ceil($total_products / $per_page) : 1;

        // 4. Lấy danh sách sản phẩm theo bộ lọc và phân trang
        $products = $this->model->getProducts($filter_type_id, $per_page, $offset);

        $product_arr = [];
        if($products){
            while($row = $products->fetch_assoc()){
                $product_arr[] = $row;
            }
        }

        $message = '';
        if(isset($_GET['msg'])){
            $map = [
                'delete_ok' => 'Xóa sản phẩm thành công',
                'delete_error' => 'Xóa sản phẩm thất bại',
                'save_ok' => 'Lưu sản phẩm thành công',
                'save_error' => 'Lưu sản phẩm thất bại'
            ];
            $message = $map[$_GET['msg']] ?? '';
        }
        include __DIR__ . '/../../views/admin/feature/manage_products.php';
    }
        
    public function addProduct(){
        if(isset($_POST['add_product'])){
            $name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = (float)($_POST['price'] ?? 0);
            $product_size = $_POST['product_size'] ?? '';
            $unit = $_POST['unit'] ?? '';
            $quantity = (int)($_POST['quantity'] ?? 0);
            $brand = $_POST['brand'] ?? '';
            $product_type_id = (int)($_POST['product_type_id'] ?? 0);
            $image_url = $_POST['image_url'] ?? '';

            if($product_type_id === 0 || empty($name) || $price <= 0){
                header("Location: /scm/public/index.php?page=product&msg=save_error");
                exit;
            }
            
            $success = $this->model->addProduct($name, $description, $product_size ,$unit ,$price, $quantity, $brand, $product_type_id, $image_url);
            
            
            $msg = $success ? 'save_ok' : 'save_error';
            header("Location: /scm/public/index.php?page=product&msg={$msg}");
            exit;
        }
        header("Location: /scm/public/index.php?page=product");
        exit;
    }
    
    public function updateProduct(){
        if(isset($_POST['update_product'])){
            $id = (int)($_POST['product_id'] ?? 0);
            $name = $_POST['product_name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = (float)($_POST['price'] ?? 0);
            $product_size = $_POST['product_size'] ?? '';
            $unit = $_POST['unit'] ?? '';
            $quantity = (int)($_POST['quantity'] ?? 0);
            $brand = $_POST['brand'] ?? '';
            $product_type_id = (int)($_POST['product_type_id'] ?? 0);
            $image_url = $_POST['image_url'] ?? '';
            $current_page = (int)($_POST['p'] ?? 1);
            $filter_type_id = (int)($_POST['type_id'] ?? 0);

            // Tạo đường dẫn trả về (kèm trang và filter)
            $redirect_url = "/scm/public/index.php?page=product&p={$current_page}";
            if($filter_type_id > 0) {
                $redirect_url .= "&type_id={$filter_type_id}";
            }

            if($id <0 || empty($name)){
                header("Location: /scm/public/index.php?page=product&p={$current_page}&msg=save_error");
                exit;
            }
    
            $success = $this->model->updateProduct($id, $name, $description, $product_size ,$unit ,$price, $quantity, $brand, $product_type_id, $image_url);
            $msg = $success ? 'save_ok' : 'save_error';
            header("Location: /scm/public/index.php?page=product&p={$current_page}&msg={$msg}");
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        $current_page = (int)($_GET['p'] ?? 1);
        $filter_type_id = (int)($_GET['type_id'] ?? 0);
        if($id <= 0){
            header("Location: /scm/public/index.php?page=product&msg=save_error");
            exit;
        }

        $product_to_edit = $this->model->getProductById($id);
        if ($product_to_edit->num_rows === 0) {
            $msg = "Không tìm thấy sản phẩm";
        }
        else {
            $product_to_edit = $product_to_edit->fetch_assoc();
        }
        if(!$product_to_edit){
            header("Location: /scm/public/index.php?page=product&msg=save_error");
            exit;
        }

        $product_types = $this->model->getProductTypes();
        $product_types = $product_types ? $product_types->fetch_all(MYSQLI_ASSOC) : [];
        include __DIR__ . '/../../views/admin/feature/update_product.php';
    }

    public function deleteProduct(){
        $id = (int)($_GET['id'] ?? 0);
        if($id <= 0){
            header("Location: /scm/public/index.php?page=product&msg=delete_error");
            exit;
        }
        
        $product = $this->model->getProductById($id);
        if ($product->num_rows === 0) {
            $msg = "Không tìm thấy sản phẩm";
        }
        else {
            $product = $product->fetch_assoc();
        }
        if(!$product){
            header("Location: /scm/public/index.php?page=product&msg=delete_error");
            exit;
        }

        if(isset($_POST['delete_product'])){
            $success = $this->model->deleteProduct($id);
            $msg = $success ? 'delete_ok': 'delete_error';
            header("Location: /scm/public/index.php?page=product&msg={$msg}");
            exit;
        }
        include __DIR__ . '/../../views/admin/feature/delete_product.php';
    }

    public function manageCustomers() {
        $customers = $this->model->getCustomers();
        $customer = [];
        if($customers){
            while($row = $customers->fetch_assoc()){
                $customer[] = $row;
            }
        }
        
        $message = '';
        if(isset($_GET['msg'])){
            $map = [
                'delete_ok' => 'Xóa khách hàng thành công',
                'delete_error' => 'Xóa khách hàng thất bại',
            ];
            $message = $map[$_GET['msg']] ?? '';
        }
        include __DIR__ . '/../../views/admin/feature/manage_customer.php';
    }

    public function deleteCustomer() {
        $id = (int)($_GET['id'] ?? 0);
        if($id <= 0){
            header("Location: index.php?page=customers&msg=delete_error");
            exit;
        }

        $kq = $this->model->deleteCustomer($id);
        $msg = $kq ? "delete_ok" : "delete_error";

        header("Location: index.php?page=customers&msg={$msg}");
        exit;
    }


    public function manageSuppliers(){
        $product_type_id = (int)($_GET['product_type_id'] ?? 0);
        $suppliers = $this->model->getSuppliers($product_type_id);
        $rows = [];
        if ($suppliers && $suppliers->num_rows > 0) {
            while ($r = $suppliers->fetch_assoc()) {
                $rows[] = $r;
            }
        }

        $message = '';
        if(isset($_GET['msg'])){
            $map = [
                'delete_ok' => 'Xóa nhà cung cấp thành công',
                'delete_error' => 'Xóa nhà cung cấp thất bại',
                'save_ok' => 'Lưu nhà cung cấp thành công',
                'save_error' => 'Lưu nhà cung cấp thất bại'
            ];
            $message = $map[$_GET['msg']] ?? '';
        }
        include __DIR__ . '/../../views/admin/feature/manage_supplier.php';
    }

    public function addSupplier() {
        if(isset($_POST['add_supplier'])){
            $name = $_POST['supplier_name'] ?? '';
            $address = $_POST['supplier_address'] ?? '';
            $email = $_POST['supplier_email'] ?? '';
            $terms = $_POST['payment_terms'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $phone = $_POST['supplier_phone'] ?? '';
            $product_type_id = (int)($_POST['product_type_id'] ?? 1);

            if(empty($name) || empty($email)){
                header("Location: index.php?page=suppliers&msg=save_error");
                exit;
            }

            $success = $this->model->addSupplier($name, $address, $email, $terms, $status, $phone, $product_type_id);
            $msg = $success ? 'save_ok' : 'save_error';
            header("Location: index.php?page=suppliers&msg={$msg}");
            exit;
        }
        header("Location: index.php?page=suppliers");
        exit;
    }

    public function updateSupplier() {
        if(isset($_POST['update_supplier'])){
            $id = (int)($_POST['supplier_id'] ?? 0);
            $name = $_POST['supplier_name'] ?? '';
            $address = $_POST['supplier_address'] ?? '';
            $email = $_POST['supplier_email'] ?? '';
            $terms = $_POST['payment_terms'] ?? '';
            $status = $_POST['status'] ?? 'active';
            $phone = $_POST['supplier_phone'] ?? '';
            $product_type_id = (int)($_POST['product_type_id'] ?? 0);

            if($id <= 0 || empty($name) || empty($email)){
                header("Location: index.php?page=suppliers&msg=save_error");
                exit;
            }
            $supplier = $this->model->getSupplierById($id);
            $upd = $this->model->updateSupplier($id, $name, $address, $email, $terms, $status, $phone, $product_type_id);
            
            if(!$supplier){
            header("Location: index.php?page=suppliers&msg=save_error");
            exit;
            }
            $msg = $upd ? 'save_ok' : 'save_error';
            header("Location: index.php?page=suppliers&msg={$msg}");
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        if($id <= 0){
            header("Location: index.php?page=suppliers&msg=save_error");
            exit;
        }

        $supplier = $this->model->getSupplierById($id);
        if(!$supplier){
            header("Location: index.php?page=suppliers&msg=save_error");
            exit;
        }
        include __DIR__ . '/../../views/admin/feature/update_supplier.php';
    }

    public function deleteSupplier() {
        $id = (int)($_GET['id'] ?? 0);
        if($id <= 0){
            header("Location: index.php?page=suppliers&msg=delete_error");
            exit;
        }

        $supplier = $this->model->getSupplierById($id);
        if(!$supplier){
            header("Location: index.php?page=suppliers&msg=delete_error");
            exit;
        }

        if(isset($_POST['confirm_delete'])){
            $success = $this->model->deleteSupplier($id);
            $msg = $success ? 'delete_ok' : 'delete_error';
            header("Location: index.php?page=suppliers&msg={$msg}");
            exit;
        }
        include __DIR__ . '/../../views/admin/feature/delete_supplier.php';
    }

    public function manageOrders() {
        $kq = $this->model->getOrders();
        $orders = [];
        if($kq && $kq->num_rows > 0){
            while($row = $kq->fetch_assoc()){
                $orders[] = $row;
            }
        }
        
        $message = '';
        if(isset($_GET['msg'])){
            $map = [
                'delete_ok' => 'Xóa thành công',
                'delete_error' => 'Xóa thất bại',
            ];
            $message = $map[$_GET['msg']] ?? '';
        }
        include __DIR__ . '/../../views/admin/feature/manage_order.php';
    }

    public function deleteOrders() {
        $id = (int)($_GET['id'] ?? 0);
        if($id <= 0){
            header("Location: index.php?page=orders&msg=delete_error");
            exit;
        }
        
        $order = $this->model->getOrderById($id); 
        
        // Nếu fetch trả về object mysqli result thì cần fetch_assoc
        if (is_object($order)) {
            $order = $order->fetch_assoc();
        }

        if (!$order) {
            header("Location: index.php?page=orders&msg=delete_error");
            exit;
        }
        
        if(isset($_POST['delete_order'])){
            $success = $this->model->deleteOrder($id);
            $msg = $success ? 'delete_ok' : 'delete_error';
            header("Location: index.php?page=orders&msg={$msg}");
            exit;
        }
        include __DIR__ . '/../../views/admin/feature/delete_order.php';
    }

    public function orderDetail() {
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->model->getOrderById($id);
        $items = $this->model->getOrderItems($id);
        include __DIR__ . '/../../views/admin/feature/order_detail.php';
    }

    public function updateOrderStatus() {
        $id = (int)$_POST['order_id'];
        $status = $_POST['order_status'];
        $ok = $this->model->updateOrderStatus($id, $status);

        header("Location: index.php?page=orders&msg=" . ($ok ? 'save_ok' : 'save_error'));
        exit;
    }
}
?>