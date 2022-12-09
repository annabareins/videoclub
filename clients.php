<?php
require_once("connect_data.php");

$sql_clients = [];
$clients = [];
if($clientsdb->count()>0){
    $sql_clients = $clientsdb->find();
    foreach ($sql_clients as $p){
        $aux = [];
        array_push($aux, $p["_id"], $p["nom"], $p["dni"], $p["penalitzacio"], $p["reserves"]);
        array_push($clients, $aux);
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
    <span class="loader"></span>
    <div class="llista_clients">
        <div class="cap">
            <h1>Clients</h1>
            <div class="cerca_field">
                <form id="form-cerca">
                    <i class="fa fa-search"></i>
                    <input type="text" id="nom" name="nom" placeholder="Cerca per nom..." >
                    <input id="filtrar-btn" type="submit" value="Cerca">
                </form>
            </div>
        </div>
        <table class="taula_clnts">
          <tr class="header_taula">
            <th> </th>
            <th>Nom</th>
            <th>Dni</th>
            <th>Penalització</th>
            <th>Reserves</th>
          </tr>
        <?php foreach ($clients as $p){?>
            <tr class="dades_clnt" data-id="<?php echo $p[0];?>">
               <td> 👤 </td>
               <td><?php echo $p[1];?></td>
               <td><?php echo $p[2];?></td>
               <td><?php echo $p[3];?></td>
               <td> 🡇 </td>
            </tr>
            <tr id="<?php echo $p[0];?>" class="reserves_clnt">
                <td>
                   <p><b>Reserves:</b></p>
                   <ul>
                   <?php foreach($p[4] as $reservaid){ ?>
                        <?php
                            $reserva = $reservesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($reservaid)]);
                            $copia = $copiesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($reserva["copia"])]);
                            $pelicula = $peliculesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($copia["pelicula"])]);
                        ?>
                        <li><?php echo $pelicula["titol"] ?></li>
                   <?php } ?>
                   </ul>
               </td>
           </tr>
        <?php } ?>
        </table>
    </div>
</div>
</body>
<script>

    $(document).ready(function (){
        $(document).on("click", ".dades_clnt", function() {
            var id = $(this).data("id");
            $('#'+id).slideToggle();
        });
    });

</script>

<script src="ajax-cerca.js"></script>
</html>