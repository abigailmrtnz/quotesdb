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

//Quote query
$result = $quote->readQuotes();

//Get row count
$num = $result->rowCount();

if(!empty($author_id)) {
	$author_object = new Author($db);
	if(!isValid($author_id, $author)) {
		echo(
			json_encode(
				array(
					"message" => "author_id Not Found"
				)
			)
		);
		$author = null;
		exit();
	}

	// author_id exists and is valid. Assign it to the quote object
	$quote->author_id = $author_id;
}

if(!empty($category_id)) {
	// Determine Whether category ID is Valid. Print an error message and exit if not.
	$category = new Category($db);
	if(!isValid($category_id, $category)) {
		echo(
			json_encode(
				array(
					"message" => "category_id Not Found"
				)
			)
		);
		$category = null;
		exit();
	}

	// category_id exists and is valid. Assign it to the quote object
	$quote->category_id = $category_id;
}

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
?>