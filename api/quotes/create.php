<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../..functions/Author.php';
include_once '../../functions/isValid.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate object
$quote = new Quote($db);

//Get data
$data = json_decode(file_get_contents("php://input"));

//creates post or outputs error message for missing parameters
if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//Set IDs to update
$quote->id = $data->id;
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

//Validates author
if (!isValid($quote->author_id, $quote)) {
    echo json_encode($no_author);
    exit();
}

//Validates category
if (!isValid($quote->category_id, $quote)) {
    echo json_encode($no_category);
    exit();
}


//Create category
if ($quote->create()) {
    echo json_encode(array('id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id));
} else {
    echo json_encode(array('message' => 'No Quotes Found'));
}
?>