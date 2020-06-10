<?php

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    http_response_code(400);
    echo json_encode(['status'=>'FAILED', 'error'=>'BAD_REQUEST']), PHP_EOL;
    die();
}

$credentials = json_decode(file_get_contents('./resources/database/database.json'), true);

try {
    $pdoConnection = new PDO(
        sprintf("mysql:host=%s;dbname=%s;", $credentials['URL'], $credentials['DATABASE']),
        $credentials['USER'],
        $credentials['PASS']
    );

    $statement = $pdoConnection->prepare(
        "SELECT ID, title, content FROM news_items ORDER BY date_created desc limit 5"
    );
    $statement->execute();

    $response = [
        'status'=>'SUCCESS',
        'error'=>'',
        'content'=>array()
    ];

    while( $row = $statement->fetch(PDO::FETCH_OBJ) ){
        array_push($response['content'], [
            'ID' => $row->ID,
            'title' => $row->title,
            'content' => $row->content
        ]);
    }
} catch (PDOException $exception){
    http_response_code(200);
    echo json_encode(['status'=>'FAILURE', 'error'=>'DB_EXCEPT']), PHP_EOL;
    die();
}

http_response_code(200);
echo json_encode($response), PHP_EOL;

?>