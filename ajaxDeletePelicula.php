<?php
    require_once("connect_data.php");



    $peliculaid = $_POST["idPelicula"];

    $pelicula = $peliculesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($peliculaid)]);
    $copies = $pelicula["copies"];


    $reservat=false;
    foreach($copies as $idcopia){

        $copia = $copiesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($idcopia)]);

        if($copia["estat"]==1){
            $reservat=true;
        }
    }

    if($reservat==false){
        foreach($copies as $idcopia){
            $copiesdb->deleteOne(['_id' => new MongoDB\BSON\ObjectId($idcopia)]);
        }
        $peliculesdb->deleteOne(['_id' => new MongoDB\BSON\ObjectId($peliculaid)]);
    }
    else{
        echo "ERROR: aquesta pelicula te una copia reservada, no es pot borrar";
    }

?>


