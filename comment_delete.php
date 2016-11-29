<?php
if (!empty($_POST['cid'])) {
	include_once 'includes/config.php';
	$cid = $_POST['cid'];
	// $query = mysql_query("DELETE FROM `comments` WHERE `cid` = $cid ") or die(mysql_error());
	$sql = "DELETE FROM `comments` WHERE `cid` = $cid ";
	if ($conn->query($sql) === FALSE) {
		echo "Error deleting record: " . $conn->error;
	}
}?>