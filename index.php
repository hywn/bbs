<!-- HTML for submitting a new comment (calls submit.php) -->
<form method="post" action="submit.php">
	<table>
		<tr>
			<td>pid:</td>
			<td><textarea name="pid"></textarea></td>
			<td>comment:</td>
			<td><textarea name="comment"></textarea></td>
		</tr>
		<tr><td></td><td><input type="submit" /></td>
	</table>

<?php


//open database
$db = new SQLite3('./posts.db');

$db->query('create table if not exists posts (
	parent text,
	id integer primary key autoincrement not null,
	comment text
)');

  // using SQL, gets all comments from database
$result = $db->query('select * from posts');

// loops through all comments and displays them in HTML
while($row = $result->fetcharray()) {

	list($parent, $id, $comment) = $row;

	echo '<div class="post">';//idk what this does
	echo $id;//idk what this does
	echo "$comment";
	echo '</div';//idk what this is for

}

// I think this is just cleanup or something <- by j. hwang
$result->finalize();

?>
