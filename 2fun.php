<?php

# initialize database

$db = new SQLite3('./posts.db');

$db->query('create table if not exists posts (
	parent  text    not null,
	id      integer not null,
	comment text,

	unique(parent, id)
)');

// TODO?: only recurse depth of 2?
// for performance?
function get_posts_rec($pid)
{
	global $db;

	$statement = $db->prepare('select * from posts where parent = :pid order by id desc'); // get pid's children
	$statement->bindValue(':pid', $pid);

	$result = $statement->execute();

	//if ($result === null) {
	//	$result->finalize();
	//	return 'done';
	//}

	$posts = [];
	while($post = $result->fetcharray(SQLITE3_ASSOC)) {
		$post['children'] = get_posts_rec("$pid.{$post['id']}");

		array_push($posts, $post);
	}

	$result->finalize();

	return $posts;
}

# given:  $pid (parent post ID), $comment (comment text)
# return: nothing
# do:     stores comment in database as a new post under parent post
function store_post($pid, $comment)
{
	global $db;

	$statement = $db->prepare('select max(id) from posts where parent = :pid');
	$statement->bindValue(':pid', $pid);

	$max = $statement->execute()->fetchArray()[0] or 0;

	$statement = $db->prepare('insert into posts (parent, id, comment) values (:pid, :id, :comment)');
	$statement->bindValue(':id', $max + 1);
	$statement->bindValue(':pid', $pid);
	$statement->bindValue(':comment', clean($comment));

	$statement->execute();
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