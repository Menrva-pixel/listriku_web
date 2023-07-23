<?php
include '../env/config.php';
include '../env/func.php';

$posts = getPostsFromDatabase(); 

header('Content-Type: application/json');
echo json_encode($posts);
?>
