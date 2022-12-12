<?php
require_once("connect_data.php");

$nom = $_POST["nom"];
$foto = $_POST["foto"];
$idPelicula = $_POST["idPelicula"];

$busca = $directorsdb->findOne(['nom' => $nom]);
$peliculaArray = [$idPelicula];

if ($busca["nom"] != $nom ){
    $insertUser = $directorsdb->insertOne([
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