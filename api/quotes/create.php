<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
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

// Determine Whether author ID is Valid. Print an error message and exit if not.
$author = new Author($db);
if(!isValid($data->author_id, $author)) {
        echo(json_encode(array('message' => 'author_id Not Found')));
        $author = null;
        exit();
}

// Determine Whether category ID is Valid. Print an error message and exit if not.
$category = new Category($db);
    if(!isValid($data->category_id, $category)) {
        echo(json_encode(array('message' => 'category_id Not Found')));
        $category = null;
        exit();
}

// Assign Input from User to the New Quote
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

// Create Quote
try {
    $quote_object->create();
    echo json_encode(array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author_id' => $quote->author_id,
            'category_id' => $quote->category_id));
} catch(PDOException $e) {
// This code executes if the call to create() fails.
    echo json_encode(array("error" => "{$e->getMessage()}"));
}