<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Author object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Validate ID
if(!isset($data->id) || !isValid($data->id, $author)) {
    echo(json_encode(array("message" => "author_id Not Found")));
    exit();
}

//error message if missing parameters
if(!isset($data->author)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters'));
    exit();
}

if(!get_object_vars($data) || !isset($data->id) || !isset($data->author)){ //If there are no parameters
    echo json_encode(array('message' => 'Missing Required Parameters'));
} else {
    //Set ID to update
    $author->id = $data->id;
    $author->author = $data->author;

    //Update post
    if(!$author->update()){
        echo json_encode(array('message' => 'Author Not Updated'));
    }
}
?>
