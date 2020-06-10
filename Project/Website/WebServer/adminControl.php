<?php

session_start();

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(400);
    echo json_encode(['status'=>'FAILED', 'error'=>'BAD_REQUEST']), PHP_EOL;
    die();
}

if(!isset($_POST['email']) || !isset($_POST['token'])){
    http_response_code(200);
    echo json_encode(['status'=>'FAILED', 'error'=>'NULL_INPUT']), PHP_EOL;
    die();
}

$email = $_POST['email'];
$password = $_POST['token'];
$credentials = json_decode(file_get_contents('./resources/database/database.json'), true);

if($email == null || $password == null){
    http_response_code(200);
    echo json_encode(['status'=>'FAILED', 'error'=>'NULL_INPUT']), PHP_EOL;
    die();
}

$_SESSION['email'] = $email;
$_SESSION['token'] = $password;

try {
    $pdoConnection = new PDO(
        sprintf("mysql:host=%s;dbname=%s;", $credentials['URL'], $credentials['DATABASE']),
        $credentials['USER'],
        $credentials['PASS']
    );

    $stmt = $pdoConnection->prepare("select email, token from admin_users where email = :email and token = :token");
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":token", $password);
    $stmt->execute();

    if($stmt->rowCount() == 0){
        http_response_code(200);
        echo json_encode(['status'=>'FAILURE', 'error'=>'AUTH_FAIL']);
        die();
    }

} catch (PDOException $exception){
    http_response_code(200);
    echo json_encode(['status'=>'FAILURE', 'error'=>'DB_EXCEPT']), PHP_EOL;
    die();
}

http_response_code(200);
echo json_encode(['status'=>'SUCCESS', 'error'=>'']);
die();

?>