<?php
include 'common.php';

if ($_POST['username']) {
	$db->exec("INSERT INTO users (username, `password`) VALUES ('{$_POST['username']}','".sha1($_POST['password'])."')") or die(print_r($db->errorInfo(), true));

	header('Location: /login.php');
}
?>
<?php include 'header.php' ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="/signup.php" method="post" class="form-horizontal">
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