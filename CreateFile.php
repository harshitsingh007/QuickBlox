<?php
 
include('CreateSession.php');
 
$session = createSession(62574, 'g75gqk5g4SP9AbU', '8-wKH4ZZhWCQBmq', 'akshat@gmail.com', 'password');
$token = $session->token;
//echo $token;
 
 
$ch = curl_init('https://api.quickblox.com/blobs.json');  
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS,
  "{
    \"blob\": 
    {
      \"content_type\": \"image/jpeg\", 
      \"name\": \"".$_POST['fileName']."\"
    }
  }"
);  
// <input> type=text and name=fileName in the form.
// $_POST['fileName'] is to get the value of 'fileName field' from the form.
// It is a simple input field in which user enters a name to create a new file on quickblox.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'QuickBlox-REST-API-Version: 0.1.0',
  'QB-Token: ' . $token
));
 
$resultJSON = curl_exec($ch);
$pretty = json_encode(json_decode($resultJSON), JSON_PRETTY_PRINT);
echo $pretty;

include('UploadFile.php');
$rj=json_decode($resultJSON,true);
//print_r($_FILES);
uploadImage($rj['blob']['blob_object_access']['params'], $_FILES['uploadFile']);
// <input> type=file and name=uploadFile in the form.
// $_FILES['uploadFile'] is to get the information of file...
// (such as name, size, tmp_name)

include('DeclareFile.php');
declareImage($rj['blob']['id'], $token, $_FILES['uploadFile']['size']);

 
?>
