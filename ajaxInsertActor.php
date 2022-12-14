<?php
require_once("connect_data.php");

$nom = $_POST["nom"];
$foto = $_POST["foto"];

$busca = $actorsdb->findOne(['nom' => $nom]);
$peliculaArray = [];

if ($busca["nom"] != $nom ){
    $insertActor = $actorsdb->insertOne([
        'nom' => $nom,
        'imatge' => $foto,
        'pelicules' => $peliculaArray
    ]);
    echo "0";
}
else {
    echo "1";
}
?>