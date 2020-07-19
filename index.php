<?php
if (!isset($_GET['pid']))
	die("oop can't find that !!");

$pid = $_GET['pid'];

echo "<h1>you are browsing $pid</h1>";
?>

<!-- HTML for submitting a new comment (calls submit.php) -->
<form method="post" action="submit.php">
	<input type="hidden" name="pid" value="<?php echo $pid ?>">
	<table>
		<tr><td>post to <?php echo $pid ?>:</td><td><textarea placeholder="your message here" name="comment"></textarea></td></tr>
		<tr><td></td><td><input type="submit" /></td></tr>
	</table>
</form>
<dl><?php

require '2fun.php';
foreach (get_posts($pid) as $post) {

	[, $id, $text] = $post;
	echo "<dt><a href=\"?pid=$pid.$id\">$id</a>: $text</dt>";

	foreach (get_posts("$pid.$id") as $comment) {
		[, $cid, $ctext] = $comment;
		echo "<dd><a href=\"?pid=$pid.$id.$cid\">$cid</a>: $ctext</dd>";
	}
}

?></dl>