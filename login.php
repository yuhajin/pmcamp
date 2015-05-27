<?php
include 'common.php';

if ($_POST['username']) {
	$stmt = $db->query("SELECT user_id, username, `password` FROM users WHERE username='{$_POST['username']}'");
	$result = $stmt->fetch();
	if ($result['username'] === $_POST['username'] && $result['password'] === sha1($_POST['password'])) {
		$_SESSION['login'] = time();
		$_SESSION['user_id'] = $result['user_id'];
		header('Location: /');
	}
}
?>
<?php include 'header.php' ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="/login.php" method="post" class="form-horizontal">
			  <div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
				  <input type="text" class="form-control" id="inputEmail3" name="username" placeholder="Username">
				</div>
			  </div>
			  <div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
				  <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="Password">
				</div>
			  </div>
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <button type="submit" class="btn btn-default">Sign in</button>
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>

<?php include 'footer.php' ?>