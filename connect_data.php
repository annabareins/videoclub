<?php
    error_reporting(E_ERROR | E_PARSE);
    require_once __DIR__ . '/vendor/autoload.php';
    $categoriesdb = (new MongoDB\Client)->videoclub->categoria;
    $actorsdb = (new MongoDB\Client)->videoclub->actor;
    $directorsdb = (new MongoDB\Client)->videoclub->director;
    $peliculesdb = (new MongoDB\Client)->videoclub->pelicula;
    $clientsdb = (new MongoDB\Client)->videoclub->client;
    $copiesdb = (new MongoDB\Client)->videoclub->copia;
    $reservesdb = (new MongoDB\Client)->videoclub->reserva;
?>