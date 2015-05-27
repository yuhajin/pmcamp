<?php include 'common.php' ?>
<?php include 'header.php' ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="/save.php" method="post" class="form-horizontal">
				<div class="form-group">
					<textarea name="content"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" value="저장하기">
				</div>
			</form>
		</div>
	</div>
<?php
$stmt = $db->query('SELECT * FROM posts ORDER BY post_id DESC');
$posts = $stmt->fetchAll();
foreach($posts as $post) {
?>
	<div class="row content">
		<p><?php echo $post['content'] ?></p>
	</div>
<?php } ?>
</div>



<?php include 'footer.php' ?>