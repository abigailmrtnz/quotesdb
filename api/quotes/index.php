<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    //Set ID
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

    // Get Raw User Input Data
    $data = json_decode(file_get_contents("php://input"));

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    include_once '../../models/Author.php';
    include_once '../../models/Category.php';
    include_once '../../functions/isValid.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    //Quote Object
    $quote = new Quote($db);

    //Select appropriate method
    switch($method) {
        case 'GET':
            if($id && empty($author_id) && empty($category_id)) {
                include_once "./read_single.php";
            } else {
                include_once './read.php';
            }
            break;
        case 'POST':
            include_once './create.php';
            break;
        case 'PUT':
            include_once './update.php';
            break;
        case 'DELETE':
            include_once './delete.php';
            break;
        default:
            echo('Failed!');
    }
?>