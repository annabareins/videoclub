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

$sql_categories = [];
$categories = [];
if($categoriesdb->count()>0){
    $sql_categories = $categoriesdb->find();
    foreach ($sql_categories as $c){
        $cat = [];
        array_push($cat, $c["_id"], $c["nom"], $c["pelicules"]);
        array_push($categories, $cat);
    }
}


?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Videoclap!</title>
    <link rel="stylesheet" href="estils.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
<div class="contenidor">
    <?php require("menu.php"); ?>
    <div class="header">
        <div class="logo"><img src="logo1.png"></div>
        <div class="filters">
            <form id="form-filtre">
                <ul>
                    <li>
                        <i class="fa fa-sliders"></i>
                        <label for="val">Mínim de valoració: </label>
                        <input type="range" id="val" name="val" min="0" max="10" oninput="this.nextElementSibling.value = this.value">
                        <output>5</output> ⭐
                    </li>
                    <li>
                        <i class="fa fa-calendar"></i>
                        <label for="any">Any de l'estrena:</label>
                        <input type="number" id="any" name="any" placeholder="YYYY" min="1980" max="2023">
                    </li>
                    <li>
                        <i class="fa fa-film" aria-hidden="true" title="PELÍCULES"></i>
                        <label > Categories: 🡇 </label>
                        <div class="desp_cat">
                            <fieldset>
                                <?php foreach ($categories as $c){?>
                                    <div>
                                      <input type="checkbox" id="<?php echo $c[0]; ?>" name="<?php echo $c[1]; ?>" value="<?php echo $c[0]; ?>">
                                      <label for="<?php echo $c[0]; ?>"><?php echo $c[1]; ?> (<?php echo count($c[2]); ?>)</label>
                                    </div>
                                <?php } ?>
                            </fieldset>
                        </div>
                    </li>
                    <li><input id="filtrar-btn" type="submit" value="Filtrar"></li>
                </ul>
            </form>
        </div>
    </div>
    <span class="loader"></span>
    <div class="llista_pelicules">
        <?php foreach ($pelicules as $p){?>
            <div class="pelicula" data-id="<?php echo $p[0];?>">
                <img src="<?php echo $p[2]; ?>" height="100%" width="180px">
                <div><?php if (strlen($p[1])>22) {echo substr($p[1], 0, 20)."...";} else{echo $p[1];}?></div>
                <div><?php echo $p[5]; ?> - <?php echo $p[3]; ?> <i class="fa fa-star" aria-hidden="true" style="color: #F1C40F"></i></div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
<script>
    $(document).ready(function (){
        $(document).on("click", ".pelicula", function() {
            var id = $(this).data("id");
            var form = $('<form action="pelicula.php" method = "POST">' + '<input type="hidden" name="id" value="'+id+'"></input>' + '</form>');
            $("body").append(form);
            $(form).submit();
        });
    });
</script>

<script src="ajax-filtre.js"></script>
</html>

