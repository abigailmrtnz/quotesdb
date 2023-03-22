<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../functions/isValid.php';


// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Quote object
$quote = new Quote($db);
$author = new Author($db);
$category = new Category($db);

//Quote query
$result = $quote->readQuotes();

//Get row count
$num = $result->rowCount();

if ($num > 0) {
    $quote_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        array_push($quote_arr, $quote_item);
    }

    echo json_encode($quote_arr);
} else {
    echo json_encode(array('message' => 'No Quotes Found'));
}


/*if($num > 0){
	$quote_arr = array();
	$quote_arr['data'] = array();

while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	extract($row);
//$quote_item = array('id' => $id, 'quote' => $quote, 'author_id' => $author_id, 'category_id' => $category_id);
$quote_item = array('id'=>$id, 'quote'=>$quote, 'author'=>$author, 'category'=>$category);
	if(isset($_GET['category_id']) && isset($_GET['author_id'])){
		if($_GET['category_id'] == $category_id && $_GET['author_id'] == $author_id) {
			array_push($quote_arr['data'], $quote_item);
		}
	}
	else if(isset($_GET['author_id'])) { 
		if($_GET['author_id'] == $author_id) {
			array_push($quote_arr['data'], $quote_item);
		}
	}
	else if(isset($_GET['category_id'])) {
		if($_GET['category_id'] == $category_id) {
			array_push($quote_arr['data'], $quote_item);
		}
	}
	else if(!isset($_GET['author_id']) && !isset($_GET['category_id'])) {
		array_push($quote_arr['data'], $quote_item);
	} 
}
$count = sizeof($quote_arr['data']);
if($count > 0) {
	echo json_encode($quote_arr['data']);	
}
else {
	echo json_encode(
	array('message' => 'No Quotes found'));
	}
} else {
	echo json_encode(
	array('message' => 'No Quotes found'));
}*/
?>