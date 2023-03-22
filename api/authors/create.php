<?php
//Header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//author object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//if parameters missing, outputs error message
if (!isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}
//Set ID to update
$author->author = $data->author;
//Create author
if ($author->create()) {
    echo json_encode(array('id' => $author->id, 'author' => $author->author));
} else { //error is author not created
    if(!$author->create()) {
        echo json_encode(array('message' => 'Author Not Created'));
    }
}
?>