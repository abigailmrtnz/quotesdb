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

//Get ID and validate
if (isset($_GET['id'])){
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    $quote->read_singleQuote();

    if ($quote->quote !== null) {
        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category);
            
            echo json_encode($quote_arr, JSON_NUMERIC_CHECK);
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
} else if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
    $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
    $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();

    if (!isValid($quote->category_id, $quote || !isValid($quote->author_id, $quote))) {
        if (!isValid($quote->category_id, $quote)) {
            echo json_encode(array('message' => 'category_id Not Found'));
            exit();
        } else if (!isValid($quote->author_id, $quote)) {
            echo json_encode(array('message' => 'author_id  Not Found'));
            exit();
        }
    }

    $quote_arr = $quote->read_singleQuote();
    echo json_encode($quote_arr, JSON_NUMERIC_CHECK);
} else if (isset($_GET['category_id'])) {
    $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();

    if (!isValid($quote->category_id, $quote)) {
        echo json_encode(array('message' => 'category_id Not Found'));
        exit();
    }
    $quote_arr = $quote->read_singleQuote();
    echo json_encode($quote_arr, JSON_NUMERIC_CHECK);
}
?>