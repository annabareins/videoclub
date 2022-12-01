<?php

    require_once("connect_data.php");

    $array = array();
    foreach ($_REQUEST as $key => $value){
        array_push($array, $key);
    }
    $dni = $array[0];

    $client = $clientsdb->findOne(['dni' => $dni]);

    $arrayClient = [];

    if($client != ""){
        array_push($arrayClient, $client["_id"], $client["nom"], $client["dni"], $client["penalitzacio"], $client["reserves"]);
    }

?>

<?php echo json_encode($arrayClient); exit(); ?>
