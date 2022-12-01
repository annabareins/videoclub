<?php
    require_once("connect_data.php");

    $client = $_POST["client"];
    $copia = $_POST["copia"];
    $dataInici = $_POST["dataInici"];
    $dataFi = $_POST["dataFi"];

    $insertReserva = $reservesdb->insertOne(['client' => $client, 'copia' => $copia, 'dataAlta' => $dataInici, 'dataFi' => $dataFi]);
    $idReserva = (string)$insertReserva->getInsertedId();
    $updateCopia = $copiesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($copia)],['$set' => ['estat' => 1]]);
    $clientReserva = $clientsdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($client)],['$push' => ['reserves' => $idReserva]]);
?>