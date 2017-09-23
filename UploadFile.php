<?php
 
function uploadImage($params,$uploadFile){

  $params=urldecode($params);
  $split1=explode('?',$params);
  $split2=explode('&',$split1[1]);

  $paramMap=[];

  foreach ($split2 as $a){
    $t=explode('=',$a,2);
    $t[0]=trim($t[0]);
    $t[1]=trim($t[1]);
    $paramMap[$t[0]]=$t[1];
  }
  $cFile = realpath($_FILES['uploadFile']['tmp_name']);
  echo $cFile;
  $handle = fopen($cFile, "r");
  $data  = fread($handle, filesize($cFile));

  $post = array(
    "Content-Type" => "image/jpeg",
    "Expires"=>$paramMap['Expires'],
      "acl"=>$paramMap['acl'],
      "key"=>$paramMap['key'],
      "policy"=>$paramMap['policy'],
      "success_action_status"=>$paramMap['success_action_status'],
      "x-amz-algorithm"=>$paramMap['x-amz-algorithm'],
      "x-amz-credential"=>$paramMap['x-amz-credential'],
      "x-amz-date"=>$paramMap['x-amz-date'],
      "x-amz-signature"=>$paramMap['x-amz-signature'],
      "file"=>$data
  );

  $ch = curl_init('https://s3.amazonaws.com/qbprod');
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$response = curl_exec($ch);
  $err = curl_error($ch);


  if ($err)
    echo "cURL Error #:" . $err;
  else
    echo $response, '<br/>';

}
?>
