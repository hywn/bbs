<?php
# only accept POST requests <- idk what this means but ill leave it here
if ($_SERVER['REQUEST_METHOD'] != 'POST')
	die('oop!');

# get form data
# might be better to use isset??
$comment = $_POST['comment'] or die('you need to comment something!');
$pid     = $_POST['pid']     or die('you need to enter the id of parent post!');

require '2fun.php';
store_post($pid, $comment);

# display confirmation
# TODO: redirect back to view parent post?
echo "thank you for your comment!<br />";
echo "<a href=\"temp.html?id=$pid\">[return]</a>";
?>