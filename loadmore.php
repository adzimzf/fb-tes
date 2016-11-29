<?php
if (!empty($_GET['lastPost'])) {
	$last_post_id = $_GET['lastPost'];
//remove pageination- from last_post_id
	$remove_string = explode("-", $last_post_id);

	$last_post_id = $remove_string[1];
	include_once 'includes/config.php';
	include_once 'includes/smileys.php';
	include_once 'includes/security.php';
//query to fetch posts < last_post_id
	// $result = mysql_query("SELECT * FROM `posts` WHERE `pid` < $last_post_id ORDER BY `pid` DESC LIMIT $post_limit");
	// $total_result = mysql_num_rows($result);
	$sql = "SELECT * FROM `posts` WHERE `pid` < $last_post_id ORDER BY `pid` DESC LIMIT $post_limit";
	$result = $connection->query($sql);
	$total_result = mysqli_num_rows($result);
	if ($total_result > 0) {

		$al = 0;while ($row = $result->fetch_assoc()) {
			$post_id = $row['pid'];?>

    <li class="<?php echo alignment($al); ?>" id="post-<?php echo $post_id; ?>"> <i class="pointer" id="pagination-<?php echo $post_id; ?>"></i>
      <div class="unit">
        <!-- Story -->
        <div class="storyUnit">
          <div class="imageUnit"> <a href="#"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/371909_1319387360_251100084_q.jpg" width="32" height="32" alt=""></a>
           <p style="float:right; text-align:right;"><a href="javascript:;" class="post-delete" id="post_delete_<?php echo $post_id; ?>">X</a></p>
            <div class="imageUnit-content">
              <h4><a href="http://www.facebook.com/itzurkarthi" target="_blank">Karthikeyan</a></h4>
              <p><?php echo timeAgo($row['date']); ?> ago via Web</p>
            </div>
          </div>
          <p class="msg_wrap"><?php echo parse_smileys(make_clickable(nl2br(stripslashes($row['desc']))), $smiley_folder); ?></p>
          <?php if (!empty($row['vid_url'])) {?>
          <iframe width="400" height="300" src="http://www.youtube.com/embed/<?php echo get_youtubeid($row['vid_url']); ?>" frameborder="0" allowfullscreen></iframe>
          <?php } elseif (!empty($row['image_url'])) {?>
          <img src="<?php echo $base_url; ?>image.php/<?php echo $row['image_url']; ?>?width=400&nocache&quality=100&image=/<?php echo $base_folder; ?>uploads/<?php echo $row['image_url']; ?>">
          <?php }?>
        </div>

        <div class="activity-comments">
<ul id="CommentPosted<?php echo $post_id; ?>">
<?php
//fetch comments from comments table using post id
			// $comments = mysql_query("SELECT * FROM `comments` WHERE `cpid`=$post_id ORDER BY `cid` ASC ");
			// $total_comments = mysql_num_rows($comments);
			$sql = "SELECT * FROM `comments` WHERE `cpid`=$post_id ORDER BY `cid` ASC ";
			$result = $connection->query($sql);
			$total_comments = mysqli_num_rows($result);
			?>
<li class="show-all" id="show-all-<?php echo $post_id; ?>" <?php if ($total_comments == 0) {?> style="display:none" <?php }?>><a href="javascript:;"><span id="comment_count_<?php echo $post_id; ?>"><?php echo $total_comments; ?></span> comments</a></li>

 <?php while ($comt = $row = $result->fetch_assoc()) {$comment_id = $comt['cid'];?>
 <li id="li-comment-<?php echo $comment_id; ?>">
<div class="acomment-avatar">
<a href="http://www.facebook.com/itzurkarthi" rel="nofollow">
<img src="http://0.gravatar.com/avatar/222dad342987a085011139578299df12?s=30&r=G" alt="Avatar Image" >
</a>
 <p style="float:right; text-align:right; font-size:10px;"><a href="javascript:;" rel="<?php echo $post_id; ?>" class="comment-delete" id="comment_delete_<?php echo $comment_id; ?>">X</a></p>
</div>
<div class="acomment-meta">
<a href="http://www.facebook.com/itzurkarthi" target="_blank">Karthi</a>  <?php echo timeAgo($comt['commented_date']); ?>
</div>
<div class="acomment-content"><p class="msg_wrap"><?php echo parse_smileys(make_clickable(nl2br(stripslashes($comt['comment']))), $smiley_folder); ?></p></div></li>
<?php }?>
</ul>
<a href="javascript:;" class="acomment-reply" title="" id="acomment-comment-<?php echo $post_id; ?>">
Write a comment..</a>
<form  method="post" id="fb-<?php echo $post_id; ?>" class="ac-form">
<div class="ac-reply-avatar"><img src="http://0.gravatar.com/avatar/222dad342987a085011139578299df12?s=30&r=G" width="30" height="30" alt="Avatar Image"></div>
<div class="ac-reply-content">
<div class="ac-textarea">
<textarea id="ac-input-<?php echo $post_id; ?>" class="ac-input" name="comment" style="height:40px;"></textarea>
<input type="hidden" id="act-id-<?php echo $post_id; ?>" name="act_id" value="<?php echo $post_id; ?>" />
</div>
<input name="ac_form_submit" class="uibutton confirm live_comment_submit" title="fb-<?php echo $post_id; ?>" id="comment_id_<?php echo $post_id; ?>" type="button" value="Submit"> &nbsp; or <a href="javascript:;" class="comment_cancel" id="<?php echo $post_id; ?>">Cancel</a>
</div>
</form>

</div>
      </div>
    </li>
    <?php
if ($al == 2) {$al = 0;} else { $al++;}
		}
	}
}
?>