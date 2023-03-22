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

// Instantiate category object
$category = new Category($db);

$result = $category->read();

//Get row count
$num = $result->rowCount();

//Check for category
if($num > 0) {
//category array
	$category_arr = array();

	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$category_item = array('id' => $id, 'category' => $category); //category instead of name
		//push to data
		array_push($category_arr['data'], $category_item);
	}
	echo json_encode($category_arr['data']);
} else {
	echo json_encode(
	array('message' => 'No Categories found'));
}
?>