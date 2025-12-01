<?php
include __DIR__ . '/../../connect/database.php';

class dbcustomer{
    private $db;

    public function __construct($connect) {
        $this->db = $connect;
    }

    public function registerCustomer($name, $fullname, $email, $phone, $address, $password){
        $name = $this->db->real_escape_string($name);
        $fullname = $this->db->real_escape_string($fullname);
        $email = $this->db->real_escape_string($email);
        $phone = $this->db->real_escape_string($phone);
        $address = $this->db->real_escape_string($address);
        $password = $this->db->real_escape_string($password);
        $password_hashed = md5($password);
        
        $check = "SELECT * FROM Customers WHERE customer_name = '$name' OR customer_email = '$email' OR customer_phone = '$phone'";
        $kq = $this->db->query($check);
        if(! $kq){
            return "Lỗi truy vấn " . $this->db->error;
        }
        if($kq->num_rows > 0){
            $row = $kq->fetch_assoc();
            if($row['customer_name'] == $name) return "Tên khách hàng đã sử dụng";
            if($row['customer_email'] == $email) return "Email đã được sử dụng";
            if($row['customer_phone'] == $phone) return "Số điện thoại đã được sử dụng";
        }
        
        $sql = "INSERT INTO Customers(customer_name, customer_fullname, customer_email, customer_phone, customer_address, customer_password, status, created_at) VALUES ('$name', '$fullname', '$email', '$phone', '$address', '$password_hashed', 'active', NOW())";
        $kq = $this->db->query($sql);
        if( !$kq){
            return "Lỗi". $this->db->error;
        }
        return true;
    }

    public function loginCustomer($username, $password) {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        $password_checked = md5($password);
        
        $sql = "SELECT * FROM Customers WHERE customer_name = '$username' LIMIT 1";
        $kq = $this->db->query($sql);

        if (!$kq) {
            return "Lỗi " . $this->db->error;
        }
        if($kq->num_rows == 0){
            return "Tài khoản không tồn tại";
        }

        $user = $kq->fetch_assoc();
        if($user['customer_password'] !== $password_checked) {
            return "Sai mật khẩu";
        }

        if($user['status'] !== 'active'){
            return "Tài khoản không hoạt động";
        }
        
        $uid = $user['customer_id'];
        $this->db->query("UPDATE Customers SET last_login = NOW() WHERE customer_id = $uid");
        return $user;
    }

    public function getCustomerDetails($customer_id){
        $customer_id = (int)$customer_id;
        $sql = "SELECT * FROM Customers WHERE customer_id = $customer_id LIMIT 1";
        $kq = $this->db->query($sql);
        if ($kq && $kq->num_rows > 0) {
            return $kq->fetch_assoc();
        }
        return null;
    }

    public function logoutCustomer() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
            $_SESSION = [];
            unset($_SESSION['customer_id'], $_SESSION['customer_name'], $_SESSION['customer']);
            
            setcookie(session_name(), "", time() - 3600);
            setcookie("customer_id","", time() - 3600);
            setcookie("customer_name", "", time() - 3600);
            
            session_destroy();
            return true;
    }

    public function updateInfo($id, $fullname, $email, $phone, $address) {
        $id = (int)$id;
        $fullname = $this->db->real_escape_string($fullname);
        $email = $this->db->real_escape_string($email);
        $phone = $this->db->real_escape_string($phone);
        $address = $this->db->real_escape_string($address);

        // Kiểm tra xem email hoặc phone mới có bị trùng với người khác không
        $check = "SELECT * FROM Customers WHERE (customer_email = '$email' OR customer_phone = '$phone') AND customer_id != $id";
        $kq_check = $this->db->query($check);
        if ($kq_check->num_rows > 0) {
            return "Email hoặc Số điện thoại đã được tài khoản khác sử dụng.";
        }

        $sql = "UPDATE Customers SET 
                customer_fullname = '$fullname',
                customer_email = '$email',
                customer_phone = '$phone',
                customer_address = '$address'
                WHERE customer_id = $id";

        if ($this->db->query($sql)) {
            return true;
        } else {
            return "Lỗi SQL: " . $this->db->error;
        }
    }

    // 2. Hàm đổi mật khẩu (Có kiểm tra mật khẩu cũ)
    public function changePassword($id, $old_pass, $new_pass) {
        $id = (int)$id;
        $old_pass_hash = md5($this->db->real_escape_string($old_pass));
        $new_pass_hash = md5($this->db->real_escape_string($new_pass));

        // Kiểm tra mật khẩu cũ có đúng không
        $check = "SELECT customer_password FROM Customers WHERE customer_id = $id";
        $result = $this->db->query($check);
        $row = $result->fetch_assoc();

        if ($row['customer_password'] !== $old_pass_hash) {
            return "Mật khẩu cũ không chính xác.";
        }

        // Cập nhật mật khẩu mới
        $sql = "UPDATE Customers SET customer_password = '$new_pass_hash' WHERE customer_id = $id";
        if ($this->db->query($sql)) {
            return true;
        }
        return "Lỗi cập nhật mật khẩu.";
    }

    public function getProductTypes() {
        $sql = "SELECT pt.product_type_id, pt.type_name, COUNT(p.product_id) as total_products
                FROM Product_types pt
                LEFT JOIN Products p ON pt.product_type_id = p.product_type_id
                WHERE pt.status = 'active'
                GROUP BY pt.product_type_id, pt.type_name
                ORDER BY pt.product_type_id ASC";

        $kq = $this->db->query($sql);

        if(!$kq) {
            return [];
        }
        $data = [];
        while($row = $kq->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    //viết riêng hàm đếm số lượng sản phẩm của 1 loại
    public function countProductsByType($type_id) {
    $type_id = (int)$type_id;
    $sql = "SELECT COUNT(*) as total FROM Products WHERE product_type_id = $type_id";
    $kq = $this->db->query($sql);
    if ($kq) {
        $row = $kq->fetch_assoc();
        return $row['total'];
    }
    return 0;
}
    public function getProductsByType($type_id, $last_id = 0, $limit = 10) {
        $type_id = (int)$type_id;

        // ---- sửa ở đây ----
        $where_last_id = $last_id > 0 ? " AND product_id < $last_id" : "";
        $sql = "SELECT * FROM Products WHERE product_type_id = $type_id $where_last_id
                ORDER BY product_id DESC
                LIMIT $limit";
        // ---- end sửa ----

        $kq = $this->db->query($sql);

        if(!$kq) {
            return "Không có sản phẩm";
        }
        $data = [];
        while($row = $kq->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function getProductDetailById($product_id) {
        $product_id = (int)$product_id;
        $sql = "SELECT * FROM Products WHERE product_id = $product_id LIMIT 1"; 
        $kq = $this->db->query($sql);

        if ($kq && $kq->num_rows > 0) {
            return $kq->fetch_assoc(); 
        }
        return null;
    }

    public function getProducts($type_id, $brands, $price_ranges, $limit, $offset) {
        $type_id = (int)$type_id;
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT p.product_id, p.product_name, p.price, p.brand, p.quantity, p.description, p.image_url, pt.type_name FROM Products p
                LEFT JOIN Product_types pt ON p.product_type_id = pt.product_type_id WHERE 1=1 ";
        
        // Lọc 1: Theo loại
        if ($type_id > 0) {
            $sql .= " AND p.product_type_id = $type_id";
        }
        
        // Lọc 2: Theo thương hiệu
        if (!empty($brands)) {
            $bds = [];
            foreach($brands as $bs) {
                $bds[] = "'" . $this->db->real_escape_string($bs) . "'";
            }
            $sql .= " AND p.brand IN (" . implode(",", $bds) . ")";
        }
        
        // Lọc 3: Theo giá
        if (!empty($price_ranges)) {
            $price_sql = [];
            foreach ($price_ranges as $range) {
                switch ($range) {
                    case 'p1': $price_sql[] = "p.price < 100000";
                        break;
                    case 'p2': $price_sql[] = "p.price BETWEEN 100000 AND 200000"; 
                        break;
                    case 'p3': $price_sql[] = "p.price > 200000"; 
                        break;
                }
            }
            if (!empty($price_sql)) {
                $sql .= " AND (" . implode(" OR ", $price_sql) . ")";
            }
        }

        $sql .= " ORDER BY p.product_id ASC LIMIT $limit OFFSET $offset";
        $kq = $this->db->query($sql);
        $data = [];
        if($kq){
            while ($row = $kq->fetch_assoc()) {
                $row['quantity'] = (int)$row['quantity'];
                $data[] = $row;
            }
        }
    return $data;
    }
    
    public function getProductById($product_id) {
        $product_id = (int)$product_id;
        $sql = "SELECT * FROM Products WHERE product_id = {$product_id}";
        $kq = $this->db->query($sql);
        return $kq->fetch_assoc();
    }

    public function countProducts($type_id, $brands, $price_ranges) {        
        $type_id = (int)$type_id;
        $sql = "SELECT COUNT(*) AS total FROM Products WHERE 1=1 ";

        // Lọc 1: Theo loại
        if ($type_id > 0) {
            $sql .= "AND product_type_id = {$type_id}";
        }
        
        // Lọc 2: Theo thương hiệu
        if (!empty($brands) && is_array($brands)) {
            $bds = [];
            foreach($brands as $bs) {
                $bds[] =  "'" . $this->db->real_escape_string($bs) . "'";
            }
            $sql .= "AND brand IN (" . implode(",", $bds) . ")";
        }
        
        // Lọc 3: Theo giá
        if (!empty($price_ranges) && is_array($price_ranges)) {
            $price_sql = [];
            foreach ($price_ranges as $range) {
                switch ($range) {
                    case 'p1': $price_sql[] = "price < 100000"; 
                        break;
                    case 'p2': $price_sql[] = "price BETWEEN 100000 AND 200000"; 
                        break;
                    case 'p3': $price_sql[] = "price > 200000"; 
                        break;
                }
            }
                $sql .= "AND (" . implode(" OR ", $price_sql) . ")";
        }

        $kq = $this->db->query($sql);
        $row = $kq->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function getBrands() {
        $sql = "SELECT DISTINCT brand FROM Products WHERE brand IS NOT NULL AND brand != '' ORDER BY brand ASC";
        return $this->db->query($sql);
    }

    public function getCart($customer_id){
        $customer_id = (int)$customer_id;
        $row = null;

        $sql = "SELECT * FROM Cart WHERE customer_id = $customer_id AND status = 'active' LIMIT 1";
        $kq = $this->db->query($sql);
        if ($kq && $kq->num_rows > 0) {
            $row = $kq->fetch_assoc();
            return $row;
        }

        $sql_new = "INSERT INTO Cart(customer_id) VALUES ($customer_id)";
        $this->db->query($sql_new);
        $new_id = $this->db->insert_id;

        return [
            'cart_id' => $new_id,
            'customer_id' => $customer_id,
            'status' => 'active'
        ];
    }

    public function addCart($customer_id, $product_id, $quantity=1){
        $customer_id = (int)$customer_id;
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;

        $cart = $this->getCart($customer_id);
        $cart_id = $cart['cart_id'];

        $sql = "SELECT * FROM Cart_Items WHERE cart_id = $cart_id AND product_id = $product_id";
        $kq = $this->db->query($sql);
        if($kq->num_rows > 0){
            $sql_upd = "UPDATE Cart_Items SET quantity = quantity + $quantity WHERE cart_id = $cart_id AND product_id = $product_id";
            $this->db->query($sql_upd);
        }
        else{
            $sql_insert = "INSERT INTO Cart_Items(cart_id, product_id, quantity) VALUES($cart_id, $product_id, $quantity)";
            $this->db->query($sql_insert);
        }
    }

    public function getCartItems($customer_id){
        $cart = $this->getCart($customer_id);
        $cart_id = $cart['cart_id'];
        $sql = "SELECT ci.*, p.product_name, p.price, p.image_url 
                FROM Cart_Items ci 
                LEFT JOIN Products p ON ci.product_id = p.product_id 
                WHERE ci.cart_id = $cart_id";
        $kq = $this->db->query($sql);
        
        $data = [];
        if($kq){
            while($row = $kq->fetch_assoc()){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function updateCart($c_item_id, $quantity){
        $c_item_id = (int)$c_item_id;
        $quantity = (int)$quantity;
        $sql = "UPDATE Cart_Items SET quantity = $quantity WHERE c_item_id = $c_item_id";
        $this->db->query($sql);
    }

    public function deleteCart($c_item_id){
        $c_item_id = (int)$c_item_id;
        $sql = "DELETE FROM Cart_Items WHERE c_item_id = $c_item_id";
        $this->db->query($sql);
    }

    public function checkOut($customer_id, $name, $phone, $address, $note = "", $selected_items = []){
        $name = $this->db->real_escape_string($name);
        $phone = $this->db->real_escape_string($phone);
        $address = $this->db->real_escape_string($address);
        $note = $this->db->real_escape_string($note);
        $cart = $this->getCart($customer_id);
        $cart_id = $cart['cart_id'];
        $items = $this->getCartItems($customer_id);

        if (!empty($selected_items)) {
            $items = array_filter($items, fn($i) => in_array($i['c_item_id'], $selected_items));
        }

        if(empty($items)){
            return "Giỏ hàng đang trống";
        }

        $total = 0;
        foreach($items as $row){
            $total += $row['price'] * $row['quantity'];
        }

        $sql = "INSERT INTO Orders(customer_id, order_date, order_total, recipient_name, recipient_phone, ship_address, ship_note)
                VALUES ($customer_id, CURDATE(), $total, '$name', '$phone', '$address', '$note')";
        $this->db->query($sql);
        $order_id = $this->db->insert_id;

        foreach($items as $item){
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $sql = "INSERT INTO Order_Items(order_id, product_id, quantity, price) VALUES($order_id, $product_id, $quantity, $price)";
            $this->db->query($sql);
        }

        foreach($items as $item){
            $c_item_id = $item['c_item_id'];
            $sql = "DELETE FROM Cart_Items WHERE c_item_id = $c_item_id";
            $this->db->query($sql);
        }

        $remaining_items = $this->getCartItems($customer_id);
        if(empty($remaining_items)){
            $sql = "UPDATE Cart SET status='checked_out' WHERE cart_id=".$cart['cart_id'];
            $this->db->query($sql);
        }
        return $order_id;
    }
    public function getOrderById($order_id) {
        $order_id = (int)$order_id;
        $sql = "SELECT * FROM Orders WHERE order_id = $order_id LIMIT 1";
        $kq = $this->db->query($sql);
        if ($kq && $kq->num_rows > 0) {
        return $kq->fetch_assoc();
    }
    return null;
}
    public function getOrderItems($order_id) {
    $order_id = (int)$order_id;
    $sql = "SELECT oi.*, p.product_name, p.image_url 
            FROM Order_Items oi
            JOIN Products p ON oi.product_id = p.product_id
            WHERE oi.order_id = $order_id";
    $result = $this->db->query($sql);
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
//lấy danh sách order của customer
    public function getCustomerOrders($customer_id) {
    $customer_id = (int)$customer_id;
    $sql = "SELECT * FROM Orders WHERE customer_id = $customer_id ORDER BY order_date DESC, order_id DESC";
    $kq = $this->db->query($sql);
    
    $data = [];
    if ($kq) {
        while ($row = $kq->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
}
?>