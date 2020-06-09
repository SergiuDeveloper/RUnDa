<?php

//    echo $_SERVER['REQUEST_METHOD'];

    if($_SERVER['REQUEST_METHOD'] !== 'GET'){
        http_response_code(400);
        echo json_encode(['status'=>'FAILED', 'error'=>'BAD_REQUEST']), PHP_EOL;
        die();
    }

    if(!isset($_GET['email'])){
        http_response_code(200);
        echo json_encode(['status'=>'FAILED', 'error'=>'NULL_INPUT']), PHP_EOL;
        die();
    }

    $email = $_GET['email'];
    $credentials = json_decode(file_get_contents('./resources/database/database.json'), true);

    try {
        $pdoConnection = new PDO(
            sprintf("mysql:host=%s;dbname=%s;", $credentials['URL'], $credentials['DATABASE']),
            $credentials['USER'],
            $credentials['PASS']
        );

        $stmt = $pdoConnection->prepare("delete from subscriptions where email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();

//        $stmt->debugDumpParams();

    } catch (PDOException $exception){
        http_response_code(200);
        echo json_encode(['status'=>'FAILURE', 'error'=>'DB_EXCEPT']), PHP_EOL;
    }

    http_response_code(200);
        echo json_encode(['status'=>'SUCCESS', 'error'=>'']), PHP_EOL;

?>
