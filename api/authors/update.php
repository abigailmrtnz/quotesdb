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

//Set ID to update
$author->id = $data->id;
$author->author = $data->author;

if (!$author->update()) {
	echo json_encode(array('message' => 'author_id Not Found'));
	exit();

} else if ($author->update()) {
	echo json_encode(array('id' => $author->id, 'author' => $author->author));

} else {
	echo json_encode(array('message' => 'Authors Not Updated'));
}
?>
