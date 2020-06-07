<?php

if( ! defined('ROOT') ){
    define('ROOT', dirname(__FILE__) . '/..');
}

require_once (ROOT . '/Utility/StatusCodes.php');
require_once(ROOT . "/Utility/ResponseHandler.php");

/**
 * Class containing common operations used in the API endpoints
 */
class CommonEndPointLogic {

    /**
     * @return void If the received request is not a HTTP GET, set a BAD REQUEST response status and end execution
     */
    public static function ValidateHTTPGETRequest() {
        CommonEndPointLogic::ValidateHTTPRequestType("GET");
    }

    /**
     * @return void If the received request is not a HTTP POST, set a BAD REQUEST response status and end execution
     */
    public static function ValidateHTTPPOSTRequest() {
        CommonEndPointLogic::ValidateHTTPRequestType("POST");
    }

    /**
     * @param $requestType  string  Request type
     * @return              void    If the received request is not a HTTP POST, set a BAD REQUEST response status and end execution
     */
    private static function ValidateHTTPRequestType($requestType) {
        if ($_SERVER["REQUEST_METHOD"] == $requestType)
            return;

        ResponseHandler::getInstance()
            ->setResponseHeader(CommonEndPointLogic::GetFailureResponseStatus("BAD_REQUEST_TYPE"))
            ->send(StatusCodes::BAD_REQUEST);
    }

    /**
     * @return array ['status' => string, 'error' => string] Requested success response status
     */
    public static function GetSuccessResponseStatus() {
        return CommonEndPointLogic::GetResponseStatus("SUCCESS", "");
    }

    /**
     * @param $error    string  The error's message
     * @return          array   ["status" => string, "error" => string] = Requested failure response status
     */
    public static function GetFailureResponseStatus($error) {
        return CommonEndPointLogic::GetResponseStatus("FAILURE", $error);
    }

    /**
     * @param $status   string  The status string
     * @param $error    string  The error's message
     * @return          array   ["status" => string, "error" => string] = Requested response status
     */
    private static function GetResponseStatus($status, $error) {
        return $responseStatus = [
            "status" => $status,
            "error" => $error
        ];
    }

    public static function encodeGETURLParams($URL, $params){
//        echo $URL, PHP_EOL;

        $URL = $URL . '?';

        foreach ($params as $paramName => $paramValue){
//            echo $paramName, PHP_EOL, $paramValue, PHP_EOL;
            $URL = $URL . $paramName . '=' . $paramValue . '&';
        }

        $URL = substr($URL, 0, strlen($URL) - 1);

        return $URL;
    }
}
?>