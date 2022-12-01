<?php
    require_once("connect_data.php");

    $date = date("Y-m-d");

    $reservaid = $_POST["idReserva"];

    $reserva = $reservesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($reservaid)]);

    $dataFi = $reserva["dataFi"];

    $penalitzacio = 0;
    if($dataFi < $date){
        $penalitzacio = 1;
    }

    $copia = $copiesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($reserva["copia"])], ['$set' => ['estat' => 0]]);
    $client = $clientsdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($reserva["client"])],['$pull' => ['reserves' => $reservaid]]);
    $client = $clientsdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($reserva["client"])],['$inc' => ['penalitzacio' => $penalitzacio]]);
    $reserves = $reservesdb->deleteOne(['_id' => new MongoDB\BSON\ObjectId($reservaid)]);

    echo $penalitzacio;
?>


