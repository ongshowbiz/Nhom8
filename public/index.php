<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
include_once __DIR__ . '/../controller/admin/admin.php';

$ctrl = new AdminController();
$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'home':
        $ctrl->home();
        break;
    case 'dashboard':
        $ctrl->dashboard();
        break;
    case 'contact':
        $ctrl->contact();
        break;

    case 'login':
        $ctrl->login();
        break;
    case 'logout':
        $ctrl->logout();
        break;
    case 'logout_confirm':
        $ctrl->logout();
        break;

    case 'product':
        $ctrl->manageProducts();
        break;
    case 'add_product':
        $ctrl->addProduct();
        break;
    case 'update_product':
        $ctrl->updateProduct();
        break;
    case 'delete_product':
        $ctrl->deleteProduct();
        break;

    case 'customers':
        $ctrl->manageCustomers();
        break;
    case 'delete_customer':
        $ctrl->deleteCustomer();
        break;

    case 'suppliers':
        $ctrl->manageSuppliers();
        break;
    case 'add_supplier':
        $ctrl->addSupplier();
        break;
    case 'update_supplier':
        $ctrl->updateSupplier();
        break;
    case 'delete_supplier':
        $ctrl->deleteSupplier();
        break;
    case 'add_supplier_phone':
        $ctrl->addSupplierPhone();
        break;
    case 'delete_supplier_phone':
        $ctrl->deleteSupplierPhone();
        break;

    case 'orders':
        $ctrl->manageOrders();
        break;

    case 'order_detail':
        $ctrl->orderDetail();
        break;
    case 'update_order_status':
        $ctrl->updateOrderStatus();
        break;
    case 'delete_order':
        $ctrl->deleteOrders();
        break;
    default:
        $ctrl->home();
        break;
}