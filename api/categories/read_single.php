<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
include_once '../../functions/isValid.php';

 // Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Category object
$category = new Category($db);

//Verify set ID or quit
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

if (!isValid($category->id, $category)) {
    echo json_encode(array('message' => 'category_id Not Found'));
    exit();
}

$category->read_singleCategory();

//Get category or output error message
$category_arr = array('id' => $category->id, 'category' => $category->category);

echo json_encode($category_arr);
?>