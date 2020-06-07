<?php



    $URL = 'unemploymentpredictionapi.azurewebsites.net/RetrieveDataCategories';

    $curlRequest = curl_init();

    curl_setopt_array(
        $curlRequest, [
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true
        ]
    );

    $response = curl_exec($curlRequest);

    $responseArray = json_decode($response, true);

    $categories = $responseArray['DataAttributes'];

    print_r($categories);

?>

