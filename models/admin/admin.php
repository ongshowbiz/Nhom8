<?php
include __DIR__ . '/../../connect/database.php';

class dbadmin{
    private $db;

    public function __construct($connect) {
        $this->db = $connect;
    }

    public function loginAdmin($admin_name, $password) {
        if(empty($admin_name) || empty($password)) {
            return "Username và password không được để trống";
        }
        
        $admin_name = $this->db->real_escape_string(trim($admin_name));
        $password = $this->db->real_escape_string(trim($password));
        $sql = "SELECT * FROM Admin WHERE admin_name = '$admin_name'";
        $kq = $this->db->query($sql);

        if (!$kq) {
            return "Lỗi truy vấn CSDL";
        }
        if ($kq->num_rows === 0) {
            return "Không tìm thấy tài khoản admin.";
        }

        $admin = $kq->fetch_assoc();
        if ($admin['status'] !== 'active') {
            return "Tài khoản không hoạt động.";
        }

        if ($password !== $admin['password']) {
            return "Sai mật khẩu.";
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua = $this->db->real_escape_string($_SERVER['HTTP_USER_AGENT'] ?? '');
        $admin_id = (int)$admin['admin_id'];

        $sql_upd = "UPDATE Admin SET last_login = NOW(), last_ip = '{$ip}', admin_agent = '{$ua}' 
                    WHERE admin_id = {$admin_id}";
        $this->db->query($sql_upd); 
        return $admin;
    }

    public function logoutAdmin() {
        unset($_SESSION['admin_id'], $_SESSION['admin_name'], $_SESSION['is_admin']);
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    public function getProductTypes() {
        $sql = "SELECT product_type_id, type_name FROM Product_types WHERE status='active' ORDER BY type_name";
        $kq = $this->db->query($sql);
        return $kq;
    }

    public function getProducts($type_id, $limit = 10, $offset) {
        $type_id = (int)$type_id;
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT p.product_id, p.product_name, p.price, p.description, p.unit, p.product_size, p.brand, p.quantity, p.image_url, pt.type_name FROM Products p
                LEFT JOIN Product_types pt ON p.product_type_id = pt.product_type_id";

        $condition = [];
        if ($type_id > 0) {
            $condition[] = "p.product_type_id = {$type_id}";
        }

        if (!empty($condition)) {
        $sql .= " WHERE " . implode(' AND ', $condition);
        }

        $sql .= " ORDER BY p.product_id DESC LIMIT {$limit} OFFSET {$offset}";

        $kq = $this->db->query($sql);
        return $kq;
    }

    public function getProductById($id) {
        $id = (int)$id;
        $sql = "SELECT * FROM Products WHERE product_id = {$id}";
        return $this->db->query($sql);
    }

    public function countProducts($type_id) {
        $type_id_safe = (int)$type_id;
        
        if ($type_id_safe > 0) {
            $sql = "SELECT COUNT(*) AS total FROM Products WHERE product_type_id = {$type_id_safe}";
        } 
        else {
            $sql = "SELECT COUNT(*) AS total FROM Products";
        }

        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function addProduct($name, $description, $product_size ,$unit ,$price, $quantity, $brand, $product_type_id, $image_url) {
        $name = $this->db->real_escape_string($name);
        $description = $this->db->real_escape_string($description);
        $product_size = $this->db->real_escape_string($product_size);
        $unit = $this->db->real_escape_string($unit);
        $brand = $this->db->real_escape_string($brand);
        $image_url = $this->db->real_escape_string($image_url);

        $price_safe = (float)$price;
        $quantity_safe = (int)$quantity;
        $type_id_safe = (int)$product_type_id;

        $sql = "INSERT INTO products (product_name, description, product_size, unit, price, quantity ,brand, product_type_id, image_url)
                VALUES ('$name', '$description', '$product_size', '$unit', $price_safe, $quantity_safe, '$brand', $type_id_safe, '$image_url')";
        
        $kq = $this->db->query($sql);
        if($kq == true){
            return true;
        }
        else {
            return false;
        }
    }

    public function updateProduct($product_id, $name, $description, $product_size ,$unit ,$price, $quantity, $brand, $product_type_id, $image_url) {
        $product_id_safe = (int)$product_id;
        if($product_id_safe <= 0){
            return false;
        }
        $name = $this->db->real_escape_string($name);
        $description = $this->db->real_escape_string($description);
        $product_size = $this->db->real_escape_string($product_size);
        $unit = $this->db->real_escape_string($unit);
        $brand = $this->db->real_escape_string($brand);
        $image_url = $this->db->real_escape_string($image_url);
        $price_safe = (float)$price;
        $quantity_safe = (int)$quantity;
        $type_id_safe = (int)$product_type_id;

        $sql = "UPDATE Products SET product_name = '{$name}', description = '{$description}', product_size = '$product_size', unit = '$unit'
        ,price = $price_safe, quantity = $quantity_safe, brand = '$brand', product_type_id = $type_id_safe, image_url = '$image_url'
                WHERE product_id = {$product_id_safe}";
        
        $kq = $this->db->query($sql);
        if($kq == true){
            return true;
        }
        else {
            return false;
        }
    }

    public function deleteProduct($product_id) {
        $product_id_safe = (int)$product_id;
        if($product_id_safe < 0){
            return false;
        }
        $sql = "DELETE FROM Products WHERE product_id = {$product_id_safe}";
        
        $kq = $this->db->query($sql);
        if($kq == true){
            return true;
        }
        else {
            return false;
        }
    }

    public function getCustomers(){
        $sql = "SELECT * FROM Customers ORDER BY customer_id DESC";
        $kq = $this->db->query($sql);
        return $kq;
    }

    public function deleteCustomer($customer_id) {
        $customer_id = (int)$customer_id;
        $sql = "DELETE FROM Customers WHERE customer_id = $customer_id";
        $kq = $this->db->query($sql);
        if($kq){
            return true;
        }
        else {
            return false;
        }
    }

    public function getSuppliers($product_type_id = 0) {
        $product_type_id = (int)$product_type_id;

        if ($product_type_id > 0) {
            $sql = "SELECT * FROM Suppliers WHERE product_type_id = {$product_type_id} ORDER BY supplier_id DESC";
        } 
        else {
            $sql = "SELECT * FROM Suppliers ORDER BY supplier_id DESC";
        }
        return $this->db->query($sql);
    }

    public function getSupplierById($supplier_id) {
        $supplier_id = (int)$supplier_id;
        $sql = "SELECT * FROM Suppliers WHERE supplier_id = {$supplier_id}";
        $kq = $this->db->query($sql);
        if($kq && $kq->num_rows > 0){
            $row = $kq->fetch_assoc();
            return $row;
        }
        else {
            return false;
        }
    }

    public function addSupplier($name, $address, $email, $terms, $status = "active", $phone, $product_type_id){
        $name = $this->db->real_escape_string((string)$name);
        $address = $this->db->real_escape_string((string)$address);
        $email = $this->db->real_escape_string((string)$email);
        $terms = $this->db->real_escape_string((string)$terms);
        $phone = $this->db->real_escape_string((string)$phone);
        $status = $this->db->real_escape_string((string)$status);
        $product_type_id = (int)$product_type_id;

        $sql = "INSERT INTO Suppliers(supplier_name, supplier_address, supplier_email, payment_terms, status, supplier_phone, product_type_id) 
                VALUES ('$name', '$address', '$email', '$terms', '$status', '$phone', $product_type_id)";
        $kq = $this->db->query($sql);
        if($kq){
            return true;
        }
        else {
            return false;
        }
    }

    public function updateSupplier($supplier_id, $name, $address, $email, $terms, $status = "active", $phone, $product_type_id){
        $supplier_id = (int) $supplier_id;
        $name = $this->db->real_escape_string((string)$name);
        $address = $this->db->real_escape_string((string)$address);
        $email = $this->db->real_escape_string((string)$email);
        $terms = $this->db->real_escape_string((string)$terms);
        $phone = $this->db->real_escape_string((string)$phone);
        $status = $this->db->real_escape_string((string)$status);
        $product_type_id = (int)$product_type_id;

        $sql = "UPDATE Suppliers SET supplier_name = '{$name}', supplier_address = '{$address}', supplier_email = '{$email}', payment_terms = '{$terms}', supplier_phone = '{$phone}', status = '{$status}', product_type_id = {$product_type_id} WHERE supplier_id = {$supplier_id}";
        $kq = $this->db->query($sql);
        return $kq ? true : false;
    }

    public function deleteSupplier($supplier_id){
        $supplier_id = (int)$supplier_id;
        $sql = "DELETE FROM Suppliers WHERE supplier_id = $supplier_id";
        $kq = $this->db->query($sql);
        if($kq){
            return true;
        }
        else {
            return false;
        }
    }

    public function getOrders() {
        $sql = "SELECT o.*, c.customer_fullname FROM Orders o LEFT JOIN Customers c ON o.customer_id = c.customer_id ORDER BY o.order_id DESC";
        $kq = $this->db->query($sql);
        return $kq;
    }

    public function deleteOrder($order_id) {
        $order_id_safe = (int)$order_id;
        if($order_id_safe < 0){
            return false;
        }
        $sql = "DELETE FROM Orders WHERE order_id = {$order_id_safe}";
        
        $kq = $this->db->query($sql);
        if($kq == true){
            return true;
        }
        else {
            return false;
        }
    }

    public function getOrderById($id) {
        $id = (int)$id;
        $sql = "SELECT o.*, c.customer_fullname FROM Orders o LEFT JOIN Customers c ON o.customer_id = c.customer_id WHERE order_id = $id";
        $kq = $this->db->query($sql);
        if($kq && $kq->num_rows > 0){
            $row = $kq->fetch_assoc();
            return $row;
        }
        else {
            return false;
        }
    }

    public function getOrderItems($order_id) {
        $order_id = (int)$order_id;
        if ($order_id <= 0){
            return false;
        }
        $sql = "SELECT oi.*, p.product_name FROM Order_Items oi LEFT JOIN Products p ON oi.product_id = p.product_id
            WHERE oi.order_id = $order_id";
        $kq = $this->db->query($sql);

        $items = [];
        if($kq && $kq->num_rows > 0){
            while ($row = $kq->fetch_assoc()) {
                $items[] = $row;
            }
            return $items;
        }
        else {
            return false;
        }
    }

    public function updateOrderStatus($order_id, $status) {
        $order_id = (int)$order_id;
        if ($order_id <= 0){
            return false;
        }
        $status = $this->db->real_escape_string($status);
        $sql = " UPDATE Orders SET order_status = '$status' WHERE order_id = $order_id";
        $kq = $this->db->query($sql);
        if($kq){
            return true;
        }
        else {
            return false;
        }
    }
}
?>