<?php
$owner="955062972279";
exec("aws ec2 describe-images --owner $owner", $output);
$json = implode('', $output);
$data = json_decode($json);
//echo count((array)$data->$Images)."\n";
foreach($data->Images as $image){
  //print_r($image);

   $ami['id'] = $image->ImageId;
   $ami['name'] = $image->Tags[0]->Value;
   $ami["description"]= $image->Description;
   $ami["date"]= $image->CreationDate;

   echo "|".$ami['id']."|".$ami['name']."|".date('Y-m-d',strtotime($ami["date"]))."|".$ami["description"]."|\n";

}
?>
