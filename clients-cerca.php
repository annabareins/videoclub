<?php
require_once("connect_data.php");

$sql_clients = [];
$clients = [];
if($clientsdb->count()>0){
    $sql_clients = $clientsdb->find(['nom' => ['$regex' => $_POST['nom']]]);
    foreach ($sql_clients as $p){
        $aux = [];
        array_push($aux, $p["_id"], $p["nom"], $p["dni"], $p["penalitzacio"], $p["reserves"]);
        array_push($clients, $aux);
    }
}
var_dump($_POST);
?>
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
