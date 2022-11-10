<?php
require_once("connect_data.php");

$sql_pelicules = [];
$pelicules = [];
if($peliculesdb->count()>0){
    $sql_pelicules = $peliculesdb->find();
    foreach ($sql_pelicules as $p){
        $aux = [];
        array_push($aux, $p["id"], $p["titol"], $p["imatge"], $p["valoracio"], $p["pegi"], $p["any"]);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class="contenidor">
    <?php require("menu.php"); ?>
    <div class="llista_pelicules">
        <?php foreach ($pelicules as $p){?>
            <div class="pelicula">
                <img src="<?php echo $p[2]; ?>" height="100%" width="180px">
                <div><?php if (strlen($p[1])>25) {echo substr($p[1], 0, 20)."...";} else{echo $p[1];}?></div>
                <div><?php echo $p[5]; ?> - <?php echo $p[3]; ?> <i class="fa fa-star" aria-hidden="true" style="color: #F1C40F"></i></div>
            </div>
        <?php } ?>
    </div>
</div>


</body>
</html>
