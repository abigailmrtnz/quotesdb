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

// Instantiate author object
$author = new Author($db);

$result = $author->readAuthors();

//Get row count
$num = $result->rowCount();

//Check for authors
if($num > 0) {
//author array
	$author_arr = array();

	while($row = $result->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		$author_item = array('id' => $id, 'author' => $author); //author instead of name
		//push to data
		array_push($author_arr['data'], $author_item);
	}
	echo json_encode($author_arr['data']);
} else {
	echo json_encode(
	array('message' => 'No Authors found'));
}
?>