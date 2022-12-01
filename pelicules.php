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
    <title>Pel·lícules</title>
    <?php require_once("head.php"); ?>
</head>
<style>
    .llista_pelicules{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        overflow-y: scroll;
        margin-top: 120px;
        width: 100%;
        float: left;
        align-content: flex-start;
        padding: 20px 3%;
    }

    .pelicula{
        display: flex;
        flex-direction: column;
        text-align: center;
        padding: 10px 20px;
        width: 240px;
        height: 390px;
    }

    .pelicula img{
        transition-duration: 0.2s;
        cursor: pointer;
    }

    .pelicula img:hover{
        opacity: 30%;
        transition-duration: 0.2s;
        cursor: pointer;
    }

    .header {
        width: 100%;
        float: left;
        height: 120px;
        background: #2E4053;
        box-shadow: 6px 9px 20px 0px #000;
        position: fixed;
        top: 0;
        margin-left: 77px;
    }
    .header .logo {
        float: left;
        width: 15%;
        height: 100%;
    }

    .header .logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        mix-blend-mode: luminosity;
    }
    .header .filters {
        width: 85%;
        float: left;
        margin-top: 30px;
    }

    .header .filters ul li{
        width: 30%;
        float: left;
        list-style-type: none;
        text-align: center;
    }
    .header .filters ul li:nth-child(3), .header .filters ul li:nth-child(4){
        width: 18%;
        text-align: left;
    }
    @media (max-width: 1470px) {
        .header .filters ul li{
            width: 25%;
            text-align: left;
            padding-left: 15px;
        }
    }
    .header .filters ul li:last-child{
        padding-right: 15px;
    }
    .header .filters label{
        font-size: 20px;
    }

    .header .filters  input[type=submit] {
        background-color: #27688b;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: -6px;
    }
    .header .filters input#val {
        height: 11px;
    }

    .header .filters input#any {
        background-color: #27688b99;
        color: #DED0C2;
    }

    .header .filters input#any::placeholder {
        color: #DED0C2;
    }
    .header .filters .desp_cat {
        width: 300px;
        background: #2E4053;
        padding: 15px 20px;
        display: none;
    }
    .header .filters .desp_cat div{
        margin-left: 15px;
    }
    .header .filters ul li:nth-child(3):hover .desp_cat {
        display: block;
    }

    .loader {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: none;
        border-top: 6px solid #FFF;
        border-right: 2px solid transparent;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
        position: fixed;
        left: 50%;
        top: 200px;
    }
    .loader::after {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top: 0;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border-left: 6px solid #27688b;
        border-bottom: 2px solid transparent;
        animation: rotation 0.5s linear infinite reverse;
    }
    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>
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
                <img src="<?php echo $p[2]; ?>" height="100%" width="200px">
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

