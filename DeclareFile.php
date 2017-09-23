<?php
 
function declareImage($id, $token, $size){

    $ch = curl_init('https://api.quickblox.com/blobs/'.$id.'/complete.json');  
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        "{\"blob\": {\"size\": ".$size."}}"
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'QuickBlox-REST-API-Version: 0.1.0',
    'QB-Token: ' . $token
    ));

    $response = curl_exec($ch);
    $err = curl_error($ch);



    if ($err)
        echo "cURL Error #:" . $err;
    else {
        $pretty = json_encode(json_decode($response), JSON_PRETTY_PRINT);
        echo $pretty;
    }

}
?>
