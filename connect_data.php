<?php

    require_once __DIR__ . '/vendor/autoload.php';
    $categoriesdb = (new MongoDB\Client)->videoclub->categoria;
    $actorsdb = (new MongoDB\Client)->videoclub->actor;
    $directorsdb = (new MongoDB\Client)->videoclub->director;
    $peliculesdb = (new MongoDB\Client)->videoclub->pelicula;
?>