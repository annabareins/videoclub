<?php
    require_once("connect_data.php");
    $titol = $_POST["titol"];
    $nomDirector = $_POST["nomDirector"];
    $duradaPelicula = $_POST["duradaPelicula"];
    $PEGI = $_POST["PEGI"];
    $valoracioPelicula = $_POST["valoracioPelicula"];
    $anyPelicula = $_POST["anyPelicula"];
    $descripcioPelicula = $_POST["descripcioPelicula"];
    $imatgePelicula = $_POST["imatgePelicula"];

    $insertMovie = $peliculesdb -> insertOne(['titol' => $titol, 'director' => $nomDirector, 'durada' => $duradaPelicula, 'pegi' => $PEGI, 'valoracio' => $valoracioPelicula, 'any' => $anyPelicula, 'descripcio' => $descripcioPelicula, 'imatge' => $imatgePelicula, 'actors' => null, 'copies' => 1])
?>