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
    $actors = $_POST["actors"];
    $categories = $_POST["categories"];

    $insertMovie = $peliculesdb -> insertOne(['titol' => $titol, 'director' => $nomDirector, 'durada' => $duradaPelicula, 'pegi' => $PEGI, 'valoracio' => $valoracioPelicula, 'any' => $anyPelicula, 'descripcio' => $descripcioPelicula, 'imatge' => $imatgePelicula]);

    $idMovie = (string)$insertMovie->getInsertedId();
    foreach($actors as $a){
        $updateMovie = $peliculesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($idMovie)],['$push' => ['actors' => $a]] );
        $updateActor = $actorsdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($a)],['$push' => ['pelicules' => $idMovie]]);
    }
    foreach ($categories as $c){
        $updateMovie = $peliculesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($idMovie)],['$push' => ['categories' => $c]] );
        $updateCategoria = $peliculesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($c)],['$push' => ['pelicules' => $idMovie]] );
    }
    $insertCopia = $copiesdb->insertOne(['estat' => 0,'pelicula' => $idMovie]);
    $idCopia = (string)$insertCopia->getInsertedId();
    $updateMovie = $peliculesdb->updateOne(['_id' => new MongoDB\BSON\ObjectId($idMovie)],['$push' => ['copies' => $idCopia]]);
?>