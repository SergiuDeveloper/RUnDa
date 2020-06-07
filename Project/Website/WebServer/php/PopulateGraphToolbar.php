<?php

    if(!defined('ROOT'))
        define('ROOT', dirname(__FILE__) . '/..');

    require_once(ROOT . '/Utility/CommonEndPointLogic.php');
    require_once(ROOT . '/Utility/StatusCodes.php');

    CommonEndPointLogic::ValidateHTTPGETRequest();



?>

