<?php
session_start();

include_once __DIR__ . '/../../controller/customer/customer.php';


$ctrl = new CustomerController();
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home':        $ctrl->home(); break;
    case 'login':       $ctrl->login(); break;
    case 'register':    $ctrl->register(); break;  
    case 'logout':      $ctrl->logout(); break;
    case 'profile_edit':$ctrl->profile_edit(); break;
    case 'product_detail':      $ctrl->productDetail(); break;


    case 'contact':     $ctrl->contact(); break;
    case 'about':       $ctrl->intro(); break;

    case 'cart':        $ctrl->cart(); break;  
    case 'product_list':        $ctrl->product_list(); break; 
    case 'product_type':        $ctrl->product_type(); break;
    case 'add_to_cart':         $ctrl->add_to_cart(); break;
    case 'update_cart':         $ctrl->update_cart(); break;
    case 'delete_cart':         $ctrl->delete_cart(); break;

    case 'check_out':           $ctrl->check_out(); break;
    case 'order_success':       $ctrl->order_success(); break;
    case 'order_list':          $ctrl->order_list(); break;
    case 'order_detail':        $ctrl->order_detail(); break;

    default:                    $ctrl->home(); break;
}
?>
