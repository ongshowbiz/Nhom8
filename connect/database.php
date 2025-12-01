<?php
include_once __DIR__ . '/../config/database.php';

$db = new Database();
$connect = $db->getConnection();
?>