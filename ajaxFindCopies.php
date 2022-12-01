<?php

    require_once("connect_data.php");

    $id = $_POST["idPelicula"];

    $copies = $copiesdb->find(['pelicula' => $id, 'estat' => 0]);

    $arrayCopia = [];

    foreach ($copies as $c){
        array_push($arrayCopia, $c["_id"]);
    }

    echo json_encode($arrayCopia);
?>