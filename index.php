<?php
if (!isset($_GET['pid']))
	$pid = "main";
else
	$pid = $_GET['pid'];

$id_parts = preg_split('/\./', $pid);
[$my_pid, $my_id] = sizeof($id_parts) == 1
	? [null, null]
	: [join(".", array_slice($id_parts, 0, sizeof($id_parts) - 1)), $id_parts[sizeof($id_parts) - 1]];

require '2fun.php';

echo "<h1>you are browsing $pid</h1>";
if ($my_id) {
	$comment = get_comment($my_pid, $my_id);
	echo "<blockquote>$comment</blockquote>";
}
if ($my_pid)
	echo "<h2><a href=\"?pid=$my_pid\">[go back]</a></h2>";

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
foreach (get_posts($pid) as $post) {

	[, $id, $text] = $post;
	echo "<dt><a href=\"?pid=$pid.$id\">$id</a>: $text</dt>";

	foreach (get_posts("$pid.$id") as $comment) {
		[, $cid, $ctext] = $comment;
		echo "<dd><a href=\"?pid=$pid.$id.$cid\">$cid</a>: $ctext</dd>";
	}
}

?></dl>