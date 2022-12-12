<?php
require_once("connect_data.php");

$nom = $_POST["nom"];
$dni = $_POST["dni"];
$email = $_POST["email"];
$telefon = $_POST["telefon"];
$reserves = [];
$busca = $clientsdb->findOne(['dni' => $dni]);


if ($busca["dni"] != $dni ){
   $insertUser = $clientsdb->insertOne([
        'dni' => $dni,
        'nom' => $nom,
        'telefon' => (int)$telefon,
        'penalitzacio' => (int)'0',
        'e-mail' => $email,
        'reserves' => $reserves
    ]);
    echo "0";
}
else {
    echo "1";
}

?>