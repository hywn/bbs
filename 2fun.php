<?php
function get_posts($pid){
	$db = new SQLite3('./posts.db');
	$statement = $db->prepare('select * from posts where parent = :pid'); // get pid's children
	$statement->bindValue(':pid', $pid);
	$result = $statement->execute();

	$array = [];
	while($row = $result->fetcharray())
		array_push($array, $row);

	$result->finalize();
	return $array;
}

function store_post($pid, $comment){
	$db = new SQLite3('./posts.db');
	$db->query('create table if not exists posts (
		parent  text    not null,
		id      integer not null,
		comment text
	)');

	$statement = $db->prepare('select max(id) from posts where parent = :pid');
	$statement->bindValue(':pid', $pid);
	$max = $statement->execute()->fetchArray()[0] or 0;

	$statement = $db->prepare('insert into posts (parent, id, comment) values (:pid, :id, :comment)');
	$statement->bindValue(':id', $max + 1);
	$statement->bindValue(':pid', $pid);
	$statement->bindValue(':comment', $comment);
	$statement->execute();

	//
	//return $nid;
}
?>