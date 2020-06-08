<?php
    header('Content-type: application/json');
    header('Content-Disposition: attachment; filename=UnemploymentData.json');

    echo file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData');
?>