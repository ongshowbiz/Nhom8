<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/../models/customer/customer.php';

if (empty($_SESSION['customer_id']) && isset($_COOKIE['remember_customer_id'])) {
    $customer_id = (int)$_COOKIE['remember_customer_id'];
    if ($customer_id > 0) {
        $model = new dbcustomer($connect);
        $user = $model->getCustomerDetails($customer_id);
        if ($user) {
            $_SESSION['customer_id'] = $user['customer_id'];
            $_SESSION['customer_name'] = $user['customer_name'];
            $_SESSION['customer_fullname'] = $user['customer_fullname'];
        } else {
            setcookie('remember_customer_id', '', time() - 3600, "/");
        }
    }
}
?>