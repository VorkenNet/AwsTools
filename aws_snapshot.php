<?php
$owner_ids="955062972279";
exec("aws ec2 describe-snapshots --owner-ids $owner_ids", $output);
$json = implode('', $output);
$data = json_decode($json);
$sumVolume=0;
//
foreach($data->Snapshots as $snap){

   $snapshot['id']=$snap->SnapshotId;
   $snapshot['data']=$snap->StartTime;
   $snapshot['volume']=$snap->VolumeSize;
   $snapshot['state']=$snap->State;
   $snapshot['descriprion']=$snap->Description;
   $snapshot['backup']=$snap->Description;
   if (isset($snap->Tags)){
      if ($snap->Tags[0]->Value=="auto_delete") $backup="*";
   } else $backup="";
   $snapshot['backup']=$backup;
   $time = strtotime($snap->StartTime);
   $newformat = date('Y-m-d',$time);
   echo $newformat."\t".$snap->SnapshotId."\t".$snap->VolumeSize."\t".$backup."\t".$snap->State."\t".$snap->Description."\n";

   $sumVolume+= $snap->VolumeSize;
}
echo count((array)$data->Snapshots)."\n";
echo $sumVolume."\n";
?>
