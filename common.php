<?php
session_start();
include 'config.php';

try {
	$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
} catch(Exception $e) {
	die('Caught Exception: '.$e->getMessage());
}