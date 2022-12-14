<?php
require_once("connect_data.php");

$sql_pelicules = [];
$pelicules = [];
if($peliculesdb->count()>0){
    $sql_pelicules = $peliculesdb->find();
    foreach ($sql_pelicules as $p){
        $aux = [];
        array_push($aux, $p["_id"], $p["titol"], $p["imatge"], $p["valoracio"], $p["pegi"], $p["any"]);
        array_push($pelicules, $aux);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="estils.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<class class="contenidor" style="background-color: #2E4053">
    <?php require_once("menu.php"); ?>
    <img style="margin: auto" src="logo1.png" width="789" height="296" alt="logo">
</class>


</body>
</html>
