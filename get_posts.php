<?php
// TODO: maybe in future make dedicated get_post.php

require '2fun.php';

if (!isset($_GET['pid']))
	$pid = "main";
else
	$pid = $_GET['pid'];

echo json_encode(get_posts_rec($pid));
?>