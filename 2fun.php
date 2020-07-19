<?php
# given:  nothing
# return: SQLite database
# do:     make sure database is set up correctly
function get_db()
{
	$db = new SQLite3('./posts.db');

	$db->query('create table if not exists posts (
		parent  text    not null,
		id      integer not null,
		comment text,

		unique(parent, id)
	)');

	return $db;
}

# given:  $pid (parent post ID)
# return: all posts underneath parent
function get_posts($pid)
{
	$db = get_db();

	$statement = $db->prepare('select * from posts where parent = :pid'); // get pid's children
	$statement->bindValue(':pid', $pid);

	$result = $statement->execute();

	$array = [];
	while($row = $result->fetcharray())
		array_push($array, $row);

	return $array;
}

# given:  $pid (parent post ID), $comment (comment text)
# return: nothing
# do:     stores comment in database as a new post under parent post
function store_post($pid, $comment)
{
	$db = get_db();

	$statement = $db->prepare('select max(id) from posts where parent = :pid');
	$statement->bindValue(':pid', $pid);

	$max = $statement->execute()->fetchArray()[0] or 0;

	$statement = $db->prepare('insert into posts (parent, id, comment) values (:pid, :id, :comment)');
	$statement->bindValue(':id', $max + 1);
	$statement->bindValue(':pid', $pid);
	$statement->bindValue(':comment', clean($comment));

	$statement->execute();
}

# given:   $pid (parent ID), $id (ID relative to parent)
# returns: the comment stored at this post
function get_comment($pid, $id)
{
	$db = get_db();

	$statement = $db->prepare('select comment from posts where parent = :pid and id = :id');
	$statement->bindValue(':pid', $pid);
	$statement->bindValue(':id', $id);

	return $statement->execute()->fetchArray()[0];
}

# function to sanitize data
# (prevents unexpected, bad things from happening)
function clean($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);

	return $data;
}
?>