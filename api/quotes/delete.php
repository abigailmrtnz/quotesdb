<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Methods, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../functions/isValid.php';

 // Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID
$quote->id = $data->id;

/*//Delete quote or output error
if(!get_object_vars($data) || !isset($data->id)) {
    echo json_encode(array('message' => 'Missing Required Parameters'));
} else {
    $quote->id = $data->id; //Sets ID
    //Deletes post
    if(!$quote->delete()) {
        echo json_encode(array('message' => 'Quote Not Deleted'));
    }
}*/

if(!isset($data->id) || !isValid($data->id, $quote)) {
    echo(json_encode(array('message' => 'Not Quotes Found')));
    exit ();
}

//Delete Quote
if (!$quote->delete()) {
    echo json_encode(array('message' => 'No Quotes Found'));
    exit();
} else {
    echo json_encode(array('id' => $quote->id));
}
/* try {
    $quote->delete();
    echo json_encode(array('id' => $quote->id));
} catch (PDOException $e) {
    echo json_encode(array("error" => "{$e->getMessage()}"));
} */
?>