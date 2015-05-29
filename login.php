<?php
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;
use Facebook\FacebookRedirectLoginHelper;

include 'common.php';

if (!isset($_SESSION['login'])) {
	require __DIR__.'/lib/facebook-php-sdk-v4/autoload.php';

	if ($_GET['fblogin'] === 'true') {
		FacebookSession::setDefaultApplication($fb_app_id, $fb_app_secret);

		$helper = new FacebookRedirectLoginHelper($fb_redirect_url);

		try {
			$session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {
			// When Facebook returns an error
		} catch(\Exception $ex) {
			// When validation fails or other local issues
		}
		if ($session) {
			// Logged in
			$request = new FacebookRequest($session, 'GET', '/me');
			$response = $request->execute();

			$graphObject = $response->getGraphObject();
			$fb_id = $graphObject->getProperty('id');
			$fb_fullname = $graphObject->getProperty('name');
			$fb_email = $graphObject->getProperty('email');

			$_SESSION['FBID'] = $fb_id;
			$_SESSION['FULLNAME'] = $fb_fullname;
			$_SESSION['EMAIL'] = $fb_email;

			if (preg_match('#^\w+@([\w-]+\.)+[a-z]{2,3}$#i', $fb_email) === false) {
				die('Invalid email address: '.$fb_email);
			}

			$stmt = $db->query("SELECT user_id, username FROM users WHERE username='{$fb_email}'");
			if ($stmt->rowCount() === 0) {
				$affected = $db->exec("INSERT INTO users (username, password) VALUES ('{$fb_email}', '')");
				if ($affected) {
					$user_id = $db->lastInsertId();
				}
			} else {
				$row = $stmt->fetch();
				$user_id = $row['user_id'];
			}

			$_SESSION['login'] = time();
			$_SESSION['user_id'] = $user_id;
		} else {
			$loginUrl = $helper->getLoginUrl(array('scope'=>'email'));
			header('Location: '.$loginUrl);
		}
	} elseif ($_POST['username']) {
		$stmt = $db->query("SELECT user_id, username, `password` FROM users WHERE username='{$_POST['username']}'");
		$result = $stmt->fetch();
		if ($result['username'] === $_POST['username'] && $result['password'] === sha1($_POST['password'])) {
			$_SESSION['login'] = time();
			$_SESSION['user_id'] = $result['user_id'];
		}
	}
}

if ($_SESSION['login']) {
	header('Location: /');
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
				  <button type="button" class="btn btn-default" onclick="location.href = '/login.php?fblogin=true'">Sign in with Facebook</button>
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>

<?php include 'footer.php' ?>