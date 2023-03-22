<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate object
$category = new Category($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//if parameters missing, outputs error message
if (!isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//Set ID
$category->id = $data->id;

//delete category
if ($category->delete()) {
    echo json_encode(array('id' => $category->id));
} else {
    echo json_encode(
        array('message' => 'Category Not Deleted')
    );
}
?>