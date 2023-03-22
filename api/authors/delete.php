<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//if parameters missing, outputs error message
if (!isset($data->author)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//Set ID
$author->id = $data->id;

//delete author
if ($author->delete()) {
    echo json_encode(array('id' => $author->id));
} else {
    echo json_encode(
        array('message' => 'Author Not Deleted')
    );
}
?>