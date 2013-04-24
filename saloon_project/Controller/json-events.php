<?php

include_once '../Model/salonModel.php';
$obj=new SalonModel();
$result=$obj->getAllCalEvents();
$json=json_encode($result);
$json=str_replace('"false"', 'false',$json);
$json=str_replace('"true"', 'true',$json);
echo $json;
?>