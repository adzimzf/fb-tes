<style>
p.msg_wrap { word-wrap:break-word; }
</style>
<?php
if (!empty($_POST['message'])) {
	include_once 'includes/config.php';
	include_once 'includes/security.php';
	include_once 'includes/smileys.php';

	$message = clean(mysqli_real_escape_string($connection, $_POST['message']));
	$message = special_chars($message);
	$time = time();
	//getting image link
	if (!empty($_POST['pic_url'])) {
		$image = strip_tags($_POST['pic_url']);
	} else {
		$image = '';
	}

	//getting video link
	if (!empty($_POST['y_link'])) {
		$video = fix_url(strip_tags($_POST['y_link']));
	} else {
		$video = '';
	}

	//insert into wall table
	// $query = mysql_query("INSERT INTO `posts` (`desc`, `image_url`, `vid_url`,`date`) VALUES ('$message', '$image', '$video','$time')") or die(mysql_error());
	// $ins_id = mysql_insert_id();
	$sql = "INSERT INTO `posts` (`desc`, `image_url`, `vid_url`,`date`) VALUES ('$message', '$image', '$video','$time')";
	if ($connection->query($sql) === TRUE) {
		$ins_id = mysqli_insert_id($connection);
	} else {
		echo "Error updating record: " . $conn->error;
	}

	$lft = array('left' => '0', 'right' => '1', 'highlight' => '2');?>
<li class="<?php echo array_rand($lft, 1); ?>" id="post-<?php echo $ins_id; ?>">
  <i class="pointer"></i>
  <div class="unit">

    <!-- Story -->
    <div class="storyUnit">
      <div class="imageUnit">
        <a href="#"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/371909_1319387360_251100084_q.jpg" width="32" height="32" alt=""></a>
         <p style="float:right; text-align:right;"><a href="javascript:;" class="post-delete" id="post_delete_<?php echo $ins_id; ?>">X</a></p>
        <div class="imageUnit-content">

          <h4><a href="http://www.facebook.com/itzurkarthi" target="_blank">Karthikeyan</a></h4>
          <p>0 sec ago</p>

        </div>
    </div>

      <p class="msg_wrap"><?php echo parse_smileys(make_clickable(nl2br(stripslashes($message))), $smiley_folder); ?></p>
       <?php if (!empty($video)) {?>
          <iframe width="400" height="300" src="http://www.youtube.com/embed/<?php echo get_youtubeid($video); ?>" frameborder="0" allowfullscreen></iframe>
          <?php } elseif (!empty($image)) {?>
          <img src="<?php echo $base_url; ?>image.php/<?php echo $image; ?>?width=400&nocache&quality=100&image=/<?php echo $base_folder; ?>uploads/<?php echo $image; ?>">
          <?php }?>

    </div>

<!-- comment starts -->
<div class="activity-comments">
<ul id="CommentPosted<?php echo $ins_id; ?>">
<li class="show-all" id="show-all-<?php echo $ins_id; ?>" style="display:none"><a href="javascript:;"><span id="comment_count_<?php echo $ins_id; ?>">0</span> comments</a></li>
  <a href="javascript:;" class="acomment-reply" title="" id="acomment-comment-<?php echo $ins_id; ?>">
Write a comment..</a>
</ul>
<form  method="post" id="fb-<?php echo $ins_id; ?>" class="ac-form">
<div class="ac-reply-avatar"><img src="http://0.gravatar.com/avatar/222dad342987a085011139578299df12?s=30&r=G" width="30" height="30" alt="Avatar Image"></div>
<div class="ac-reply-content">
<div class="ac-textarea">
<textarea id="ac-input-<?php echo $ins_id; ?>" class="ac-input" name="comment" style="height:40px;"></textarea>
<input type="hidden" id="act-id-<?php echo $ins_id; ?>" name="act_id" value="<?php echo $ins_id; ?>" />
</div>
<input name="ac_form_submit" class="uibutton confirm live_comment_submit" title="fb-<?php echo $ins_id; ?>" id="comment_id_<?php echo $ins_id; ?>" type="button" value="Submit"> &nbsp; or <a href="javascript:;" class="comment_cancel" id="<?php echo $ins_id; ?>">Cancel</a>
</div>
</form>
</div>
<!-- comment ends -->
  </div>
</li>
<?php }?>