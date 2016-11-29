<?php
include 'includes/config.php';
include 'includes/smileys.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<!-- Always force latest IE rendering engine or request Chrome Frame -->
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
<!-- Use title if it's in the page YAML frontmatter -->
<title>Facebook Dynamic Timeline Wall Script Version 2.0 with PHP, Jquery, Mysql</title>
<link href="<?php echo $base_url; ?>assets/stylesheets/normalize.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $base_url; ?>assets/stylesheets/all.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $base_url; ?>assets/stylesheets/timeline.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $base_url; ?>assets/stylesheets/fb-buttons.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?php echo $base_url; ?>assets/stylesheets/comments.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body class="index">
<div class="container">
  <center>
    <img src="<?php echo $base_url; ?>assets/images/coverpage.png">
  </center>
  <ol class="timeline clearfix">
    <li class="spine"> <a href="#" title=""></a> </li><br>
    <li class="left"> <i class="pointer"></i>
      <div class="unit" id="tabs">
        <ul class="actions">
          <li><a href="#tabs-1"><i class="icon icon-status"></i>Status</a></li>
          <li><a href="#tabs-2"><i class="icon icon-photo"></i>Add Picture</a></li>
          <li><a href="#tabs-3"><i class="icon icon-video"></i>Add Video</a></li>

        </ul>
        <span class="ajax_indi"><img src="<?php echo $base_url; ?>assets/images/loader.gif"></span>
        <!-- Units -->
        <div class="actionUnits" id="tabs-1">
         <form id="npost" name="npost">
          <p class="formUnit" id="Status"> <i class="active"></i>
            <textarea name="message" placeholder="What's on your mind?" id="message" cols="30" rows="3"></textarea>
          <ol class="controls clearfix">
            <li class="post">
              <input class="uibutton confirm fb_submit" type="button" title="npost" value="Post">
            </li>
          </ol>
          </p>
          </form>
        </div>
        <div class="actionUnits" id="tabs-2">
         <form id="picpost" name="picpost">
          <p class="formUnit"> <i class="active_pic"></i>
            <textarea name="message" placeholder="What's on your mind?" id="pmessage" cols="30" rows="3"></textarea>
            <input type="hidden" name="pic_url" id="pic_url">
            <button class="uibutton" type="button" id="upload_pic">Upload Picture</button><span id="statuss"></span>
          <ol class="controls clearfix">
            <li class="post">
              <input class="uibutton confirm fb_submit"  type="button" value="Post" title="picpost">
            </li>
          </ol>
          </p>
          <p id="files"></p>
          </form>
        </div>
        <div class="actionUnits" id="tabs-3">
         <form id="vidpost" name="vidpost">
          <p class="formUnit" id="Status"> <i class="active_vid"></i>
            <textarea name="message" placeholder="Video Description" id="vmessage" cols="30" rows="3"></textarea>
            <input type="text" name="y_link" style="width:100%" id="y_link" placeholder="Enter Youtube Url - www.youtube.com/watch?v=rdmycu13Png">
          <ol class="controls clearfix">
            <li class="post">
              <input class="uibutton confirm fb_submit" type="button" value="Post" title="vidpost">
            </li>
          </ol>
          </p>
         </form>
        </div>
        <!-- / Units -->
      </div>
    </li>
    <li class="right"> <i class="pointer"></i>
      <div class="unit">
        <!-- Story -->
        <div class="storyUnit">
          <div class="imageUnit"> <a href="#"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/371909_1319387360_251100084_q.jpg" width="32" height="32" alt=""></a>
            <div class="imageUnit-content">
              <h4><a href="http://www.facebook.com/itzurkarthi" target="_blank">Karthikeyan</a></h4>
              <p>Follow me on Facebook</p>
            </div>
          </div>
          <p> Features:</p><ul><li><span style="line-height: 15px;">Share Updates | Upload pictures | Share Youtube Videos | Post Hightlights</span></li>
	<li>Support Smileys</li>
    <li>FB like Commenting System</li>
    </ul>
        </div>
        <!-- / Story -->
        <!-- Units -->
        <ol class="storyActions">
        <div class="fb-like" data-href="https://www.facebook.com/completeweb2.0" data-send="false" data-width="410" data-show-faces="true"></div>
        </ol>
        <!-- / Units -->
      </div>
    </li>
    </ol>
<style>
p.msg_wrap { word-wrap:break-word; }
</style>
    <ol class="timeline clearfix" id="tupdate">
 <?php
include 'includes/security.php';
$sql = "SELECT * FROM `posts` ORDER BY `pid` DESC LIMIT $post_limit";
$result = $connection->query($sql);
// $result = mysql_query("SELECT * FROM `posts` ORDER BY `pid` DESC LIMIT $post_limit");
?>

    <?php $al = 0;while ($row = $result->fetch_assoc()) {
	$post_id = $row['pid'];?>

    <li class="<?php echo alignment($al); ?>" id="post-<?php echo $post_id; ?>"> <i class="pointer" id="pagination-<?php echo $post_id; ?>"></i>
      <div class="unit">
        <!-- Story -->
        <div class="storyUnit">
          <div class="imageUnit"> <a href="#"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash4/371909_1319387360_251100084_q.jpg" width="32" height="32" alt=""></a>
           <p style="float:right; text-align:right;"><a href="javascript:;" class="post-delete" id="post_delete_<?php echo $post_id; ?>">X</a></p>
            <div class="imageUnit-content">
            <!-- user -->
            <!-- http://www.facebook.com/$db['id'->user] -->
              <h4><a href="http://www.facebook.com/adzhaim" target="_blank">Karthikeyan</a></h4>
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
	$sql = "SELECT * FROM `comments` WHERE `cpid`=$post_id ORDER BY `cid` ASC ";
	$result = $connection->query($sql);
	$total_comments = $result->num_rows;
	// $comments = mysql_query("SELECT * FROM `comments` WHERE `cpid`=$post_id ORDER BY `cid` ASC ");
	// $total_comments = mysql_num_rows($comments);
	?>
<li class="show-all" id="show-all-<?php echo $post_id; ?>" <?php if ($total_comments == 0) {?> style="display:none" <?php }?>><a href="javascript:;"><span id="comment_count_<?php echo $post_id; ?>"><?php echo $total_comments; ?></span> comments</a></li>
  <!-- $row = $result->fetch_assoc() -->
 <?php while ($comt = $result->fetch_assoc()) {$comment_id = $comt['cid'];?>
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
        <!-- / Units -->
      </div>
    </li>
    <?php
if ($al == 2) {$al = 0;} else { $al++;}
}?>
  </ol>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript">
    var domain = "<?php echo $base_url; ?>";
      // Simple infinite Scrolling

      $(function(){

          var $timeline = $('#tupdate'),
              $spinner = $('#Spinner').hide();

          function loadMore(){

            $(window).unbind('scroll.posts');

            $spinner.show();

            $.ajax({
              url: "loadmore.php?lastPost="+ $(".pointer:last").attr('id'),
              success: function(html){
                  if(html){
                      $timeline.append(html);
                      $spinner.hide();
                  }else{
                      $spinner.html('<p>No more posts to show.</p>');
                  }

                  $(window).bind('scroll.posts',scrollEvent);
              }
            });
          }


          //lastAddedLiveFunc();
          $(window).bind('scroll.posts',scrollEvent);

          function scrollEvent(){
            var wintop = $(window).scrollTop(), docheight = $(document).height(), winheight = $(window).height();
            var  scrolltrigger = 0.95;

            if  ((wintop/(docheight-winheight)) > scrolltrigger)  loadMore();
          }

      });

 $(function(){
	  $('#tabs div').hide();
	  $('#tabs div:first').show();
	  $('#tabs ul li:first').addClass('active');
	  $('#tabs ul li a').click(function(){
	  $('#tabs ul li').removeClass('active');
	  $(this).parent().addClass('active');
	  var currentTab = $(this).attr('href');
	  $('#tabs div').hide();
	  $(currentTab).show();
	  return false;
	  });


	  jQuery('a.acomment-reply').live("click", function(e) {
			var getpID =  jQuery(this).attr('id').replace('acomment-comment-','');
			jQuery("#acomment-comment-"+getpID).hide();
			jQuery("#fb-"+getpID).css('display','block');
			jQuery("#ac-input-"+getpID).focus();
						e.preventDefault();
								});

	jQuery('a.comment_cancel').live("click", function(e) {

			var getpID =  jQuery(this).attr('id');

			jQuery("#fb-"+getpID).css('display','');
			jQuery("#acomment-comment-"+getpID).show();
			jQuery("#ac-input-"+getpID).val('');
		e.preventDefault();
	});



});
    </script>
<script src="<?php echo $base_url; ?>assets/javascripts/all.js" type="text/javascript"></script>
<script src="<?php echo $base_url; ?>assets/javascripts/ajaxupload.3.5.js" type="text/javascript"></script>
<script type="text/javascript" >
	jQuery(document).ready(function() {
		var btnUpload=jQuery('#upload_pic');
		var status=jQuery('#statuss');
		new AjaxUpload(btnUpload, {
			action: '<?php echo $base_url; ?>upload-img.php',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|jpeg|gif|png)$/.test(ext))){
                    // extension is not allowed
					status.text('Only JPG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');

				//Add uploaded file to list
				if(response==="success"){
					jQuery('#pic_url').val(file);
					//jQuery('#files').empty();
					//jQuery('#files').text(file+' added').addClass('successe');
					//var ts = Math.round((new Date()).getTime() / 1000);
					jQuery('#files').html('<img src="<?php echo $base_url; ?>uploads/'+file+'" height="100" width="100">');
				} else{
					//jQuery('#files').text(file+' upload failed').addClass('errore');
				}
			}
		});

	});
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=133252466777552";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_floating_style addthis_counter_style" style="left:50px;top:50px;">
<a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
<a class="addthis_button_tweet" tw:count="vertical"></a>
<a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
<a class="addthis_button_linkedin_counter" li:counter="top"></a>
<a class="addthis_counter"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
<!-- AddThis Button END -->
</body>
</html>