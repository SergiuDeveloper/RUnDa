<?php

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(400);
    echo json_encode(['status'=>'FAILED', 'error'=>'BAD_REQUEST']), PHP_EOL;
    die();
}

if(!isset($_POST['id'])){
    http_response_code(200);
    echo json_encode(['status'=>'FAILED', 'error'=>'NULL_INPUT']), PHP_EOL;
    die();
}

$postID = $_POST['id'];
$credentials = json_decode(file_get_contents('./resources/database/database.json'), true);

try {
    $pdoConnection = new PDO(
        sprintf("mysql:host=%s;dbname=%s;", $credentials['URL'], $credentials['DATABASE']),
        $credentials['USER'],
        $credentials['PASS']
    );

    $statement = $pdoConnection->prepare(
        "delete from news_items where id = :id"
    );
    $statement->bindParam(":id", $postID);
    $statement->execute();

} catch (PDOException $exception){
    http_response_code(200);
    echo json_encode(['status'=>'FAILURE', 'error'=>'DB_EXCEPT']), PHP_EOL;
    die();
}

http_response_code(200);
echo json_encode(['status'=>'SUCCESS', 'error'=>'']), PHP_EOL;

?>