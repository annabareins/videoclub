<?php
    require_once("connect_data.php");

    //PELICULA
    $id=$_POST['id'];
    $pelicula = "";
    if($peliculesdb->count()>0){
        $pelicula = $peliculesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }

    //CATEGORIES
    //Llistem les ids de les categories
    $categoriesids = [];
    foreach ($pelicula["categories"] as $c){
        $categoriesids[] = new MongoDB\BSON\ObjectId($c);
    }
    //Busquem les categories a la taula categoria
    $categories = '';
    if($categoriesdb->count()>0){
        $categories = $categoriesdb->find(['_id' =>['$in' => $categoriesids]]);
    }

    //ACTORS
    //Llistem les ids dels actors
    $actorsids = [];
    foreach ($pelicula["actors"] as $a){
        $actorsids[] = new MongoDB\BSON\ObjectId($a);
    }
    //Busquem les categories a la taula categoria
    $actors = '';
    if($actorsdb->count()>0){
        $actors = $actorsdb->find(['_id' =>['$in' => $actorsids]]);
    }

    //DIRECTOR
    $director = '';
    if($directorsdb->count()>0){
        $director = $directorsdb->findOne(['_id' => new MongoDB\BSON\ObjectId($pelicula["director"])]);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<style>
    .peliculaid{
        display: flex;
        flex-direction: column;
        text-align: center;
        overflow-y: scroll;
        width: 100%;
        padding: 40px 8%;
    }

    .informacio{
        display: flex;
    }

    .informacio2{
        display: flex;
        flex-direction: column;
        padding: 0 50px 20px 50px;
    }

    .titolpuntuacio{
        display: flex;
        justify-content: space-between;
        padding-bottom: 20px;
        align-items: center;
    }

    .titol{
        font-size: 55px;
    }

    .puntuacio{
        font-size: 45px;
    }

    .categories{
        display: flex;
        padding-bottom: 20px;
    }

    .categories div{
        background: #354C63;
        border-radius: 20px;
        padding: 5px 15px;
        width: 150px;
        font-size: 18px;
        margin-right: 50px;
    }

    .duradaanypegi{
        display: flex;
        justify-content: space-between;
        font-size: 30px;
        padding-bottom: 20px;
    }

    .descripcio{
        text-align: justify;
        text-justify: inter-word;
        font-size: 20px;
        padding-bottom: 30px;
    }

    .directorreserva{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .director{
        display: flex;
        flex-direction: column;
        font-size: 25px;
        text-align: left;
    }

    .botoreserva{
        background: #74818E;
        border: none;
        color: white;
        padding: 10px 30px;
        font-size: 25px;
        border-radius: 15px;
    }

    .botoreserva:hover{
        background: #6B7885;
    }

    .imatgeactor{
    }

    .actors{
        display: flex;
        padding: 30px 0;
    }

    .actor{
        padding: 0 30px;
    }

    .actor img{
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }


</style>
<body>
<class class="contenidor">
    <?php require_once("menu.php"); ?>
    <div class="peliculaid">
        <div class="informacio">
            <div class="foto">
                <img src="<?php echo $pelicula["imatge"]; ?>" style="width: 350px; height: 100%;">
            </div>
            <div class="informacio2">
                <div class="titolpuntuacio">
                    <div class="titol"><b><?php echo $pelicula["titol"]; ?></b></div>
                    <div class="puntuacio"><?php echo $pelicula["valoracio"]; ?> <i class="fa fa-star" aria-hidden="true" style="color: #F1C40F"></i></div>
                </div>
                <div class="categories">
                    <?php foreach($categories as $c) { ?>
                        <div><?php echo $c["nom"]; ?></div>
                    <?php } ?>
                </div>
                <div class="duradaanypegi">
                    <div class="durada"><?php echo $pelicula["durada"]; ?> min</div>
                    <div class="any"><?php echo $pelicula["any"]; ?></div>
                    <div class="pegi"><?php echo $pelicula["pegi"]; ?></div>
                </div>
                <div class="descripcio"><?php echo $pelicula["descripcio"]; ?></div>
                <div class="directorreserva">
                    <div class="director">
                        <div class="dirigit"><b>Director</b></div>
                        <div class="nomdirector"><?php echo $director["nom"]; ?></div>
                    </div>
                    <div class="reserva">
                        <button class="botoreserva" id="reserva">RESERVAR</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="actors">
            <?php foreach($actors as $a) { ?>
                <div class="actor">
                    <img class="imatgeactor" src="<?php echo $a["imatge"];?>">
                    <div class="nomactor"><?php echo $a["nom"]; ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
</class>
</body>
</html>