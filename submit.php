<?php

require '2fun.php';

# only accept POST requests <- idk what this means but ill leave it here
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo 'oop';
	exit;
}

# get form data
$comment = $_POST['comment'] or die('you need to comment something!');
$pid = $_POST['pid'] or die('you need to enter the id of parent post!');
/*
$statement = $db->prepare('insert into posts (parent, comment) values (:pid, :ment)');
$statement->bindValue(':pid', $pid);
$statement->bindValue(':ment', $comment);
$statement->execute();
*/
store_post($pid, $comment);
# display confirmation
echo "thank you for your comment!<br />";
echo "<a href=\"index.php?pid=$pid\">[return to index]</a>";

?>
