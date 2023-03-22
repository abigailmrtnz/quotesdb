<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../functions/isValid.php';

 // Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

//Verify set ID or quit
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

if (!isValid($author->id, $author)) {
    echo json_encode(array('message' => 'author_id Not Found'));
    exit();
}

$author->read_single();

//Get Author or output error message
$author_arr = array('id' => $author->id, 'author' => $author->author);

echo json_encode($author_arr);
?>