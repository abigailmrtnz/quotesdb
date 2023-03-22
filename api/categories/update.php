<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods,Content-Type, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Validate ID
if(!isset($data->id) || !isValid($data->id, $category)) {
    echo(json_encode(array("message" => "category_id Not Found")));
    exit();
}

//error message if missing parameters
if(!isset($data->category)) {
    echo json_encode(
        array('message' => 'Missing Required Parameters'));
    exit();
}

if(!get_object_vars($data) || !isset($data->id) || !isset($data->category)){ //If there are no parameters
    echo json_encode(array('message' => 'Missing Required Parameters'));
} else {
    //Set ID to update
    $category->id = $data->id;
    $category->category = $data->category;

    //Update post
    if(!$category->update()){
        echo json_encode(array('message' => 'Category Not Updated'));
    }
}
?>
