<?php
    require_once("connect_data.php");
    $idMovie = $_POST["idPelicula"];

    $insertCopia = $copiesdb->insertOne(['estat' => 0,'pelicula' => $idMovie]);
    $idCopia = (string)$insertCopia->getInsertedId();
    $updateMovie =  $updateMovie = $peliculesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($idMovie)],['$push' => ['copies' => $idCopia]]);
?>
