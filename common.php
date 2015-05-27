<?php
session_start();
include 'config.php';

$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
?>