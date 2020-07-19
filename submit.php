<?php
function get_posts($pid){
    $db = new SQLite3('./posts.db');
    $result = $db->query('select * from posts where parent = $pid'); // get pid's children

    $array; // declare an array??? i dont know if this would work
    while($row = $result->fetcharray()) {
        list($parent, $id, $text) = $row;
        array_push($array, $parent, $id, $text);// add a new element to $array
    }

    return $array;
}

function store_post($pid, $comment){
	$db = new SQLite3('./posts.db');
	$db->query('create table if not exists posts (
	        parent text,
	        id integer primary key autoincrement not null,
	        comment text
	  )');


	$statement = $db->prepare('insert into posts (parent, comment) values (:pid, :comment)');
	$statement->bindValue(':pid', $pid);
	$statement->bindValue(':comment', $comment);
	$statement->execute();

  //$statement = $db->prepare('select max(id) from posts where parent = $pid"'';
	//return $nid;
}

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
echo '<a href="index.php">[return to index]</a>';

?>
