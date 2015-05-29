<?php include 'common.php' ?>
<?php include 'header.php' ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<form action="/save.php" method="post" class="form-horizontal post">
				<div class="form-group">
					<div class="row">
						<div class="col-md-10">
							<textarea name="content" class="form-control" rows="3"></textarea>
						</div>
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary btn-save">저장하기</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
<?php
$stmt = $db->query('SELECT posts.content, users.username, users.user_id FROM posts, users WHERE users.user_id = posts.user_id ORDER BY posts.post_id DESC');
$posts = $stmt->fetchAll();
foreach($posts as $post) {
?>
	<div class="row content">
		<p><?php echo $post['content'] ?></p>
		<div class="meta">by <span class="user"><?php echo $post['username'] ?></span></div>
	</div>
<?php } ?>
</div>

<script>
$('form.post').submit(function(event){
	event.preventDefault();
	var content = this.elements.content.value;
	$.ajax({
		async: true,
		url : '/save.php',
		method : 'post',
		data : {content:content},
		success : function(data) {
			var $firstContent = $('.row.content:first');
			var $content = $firstContent.clone();

			$content.find('p').text(content);
			$content.insertBefore($firstContent);
			$('textarea').val('').focus();
		},
		error : function() {
			console.log('error');
		}
	});
});
</script>

<?php include 'footer.php' ?>