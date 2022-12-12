<?php
require_once("connect_data.php");

$id = $_POST["idClient"];
$busca = $clientsdb->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
$reserves = (array)$busca["reserves"];
if(!empty($reserves)){
    echo "1";
}
else{
    $delete = $clientsdb->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}


?>