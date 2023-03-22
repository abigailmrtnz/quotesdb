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

//Quote post missing required params message
if (!isset($_GET['id']) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}

//Input from user
$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;
$quote->id = $_GET['id'];

//Error is author id not valid
if (!isValid($quote->author_id, $quote)) {
    echo json_encode(array('message' => 'author_id Not Found'));

}

//Error if category id is not valid
if (!isValid($quote->category_id, $quote)) {
    echo json_encode(array('message' => 'category_id Not Found'));
}

if ($quote->create()) {
    echo json_encode(array('id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id));
} else {
    echo json_encode(array('message' => 'Quotes Not Created'));
}


// //quotes post author id error
// $author = new Author($db);
// if(!isValid($data->author_id, $author)) {
//         echo(json_encode(array('message' => 'author_id Not Found')));
//         $author = null;
//         exit();
// }
// //Quotes post category id error 
// $category = new Category($db);
//     if(!isValid($data->category_id, $category)) {
//         echo(json_encode(array('message' => 'category_id Not Found')));
//         $category = null;
//         exit();
// }


// // Create Quote
// try {
//     $quote_object->create();
//     echo json_encode(array(
//             'id' => $quote->id,
//             'quote' => $quote->quote,
//             'author_id' => $quote->author_id,
//             'category_id' => $quote->category_id));
// } catch(PDOException $e) {
// // This code executes if the call to create() fails.
//     echo json_encode(array("error" => "{$e->getMessage()}"));
// }

/*
if (!isset($data->category)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
    exit();
}
//Set ID to update
$category->category = $data->category;
//Create category
if ($category->create()) {
    echo json_encode(array('id' => $category->id, 'category' => $category->category));
} else { //error is category not created
    if(!$category->create()) {
        echo json_encode(array('message' => 'Category Not Created'));
    }
}
*/
?>