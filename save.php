<?php
include 'common.php';

if (!$_SESSION['user_id']) {
	header('X-Error-Message: Incorrect username', true, 500);
    die('Invalid user ID');
}

if ($_POST['content']) {
	$affected = $db->exec("
		INSERT INTO posts (user_id, content, like_count, timestamp)
		VALUES ({$_SESSION['user_id']}, '{$_POST['content']}', 0, ".time().")
	");

	echo 'Saved '.$affected;
}
?>