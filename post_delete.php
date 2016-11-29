<?php
if (!empty($_POST['pid'])) {
	include_once 'includes/config.php';
	$pid = $_POST['pid'];
	// $query = mysql_query("DELETE FROM `posts` WHERE `pid` = $pid ") or die(mysql_error());
	$sql = "DELETE FROM `posts` WHERE `pid` = $pid ";
	if ($conn->query($sql) === FALSE) {
		echo "Error deleting record: " . $conn->error;
	}
}?>