<style>
p.msg_wrap { word-wrap:break-word; }
</style>
<?php
error_reporting(0);
if (!empty($_POST['comment']) && !empty($_POST['act_id'])) {
	include_once 'includes/config.php';
	include_once 'includes/security.php';
	include_once 'includes/smileys.php';

	//clean the comment message
	$comment = clean(mysqli_real_escape_string($connection, $_POST['comment']));
	$comment = special_chars($comment);
	$time = time();
	$post_id = $_POST['act_id'];

	//insert into wall table
	$sql = "INSERT INTO `comments` (`comment`, `cpid`, `commented_date`) VALUES ('$comment', '$post_id','$time')";
	// $query = mysql_query("INSERT INTO `comments` (`comment`, `cpid`, `commented_date`) VALUES ('$comment', '$post_id','$time')") or die(mysql_error());

	if ($connection->query($sql) === TRUE) {
		$ins_id = mysqli_insert_id($connection);
	} else {
		echo "Error updating record: " . $conn->error;
	}

	?>
<li id="li-comment-<?php echo $ins_id; ?>">
<div class="acomment-avatar">
<a href="http://www.facebook.com/itzurkarthi" rel="nofollow">
<img src="http://0.gravatar.com/avatar/222dad342987a085011139578299df12?s=30&r=G" alt="Avatar Image" >
</a>
<p style="float:right; text-align:right; font-size:10px;"><a href="javascript:;" rel="<?php echo $post_id; ?>" class="comment-delete" id="comment_delete_<?php echo $ins_id; ?>">X</a></p>
</div>
<div class="acomment-meta">
<a href="http://www.facebook.com/itzurkarthi" target="_blank">Karthi</a>  0 sec ago
</div>
<div class="acomment-content"><p class="msg_wrap"><?php echo parse_smileys(make_clickable(nl2br(stripslashes($comment))), $smiley_folder); ?></p></div></li>
<?php }?>