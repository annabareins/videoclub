<?php
require_once("connect_data.php");

if($reservesdb->count()>0){
    $reserves = $reservesdb->find();
}

$resumreserva = [];
foreach ($reserves as $reserva) {
    $copia = $copiesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($reserva["copia"])]);
    $pelicula = $peliculesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($copia["pelicula"])]);
    $client = $clientsdb->findOne(['_id' => new MongoDB\BSON\ObjectId($reserva["client"])]);
    $resumreserva[] = [$reserva["_id"], $reserva["dataAlta"], $reserva["dataFi"], $copia["_id"], $pelicula["titol"], $client["_id"], $client["nom"], $client["dni"]];
}

$date = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Llistat reserves</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php require_once("head.php"); ?>
</head>
<style>
    .llistatReserves{
        width: 100%;
        display: flex;
        flex-direction: column;
        overflow-y: scroll;
        padding: 50px 100px;
    }

    .novaReserva{
        display: flex;
        justify-content: center;
        align-items: center;
        padding-bottom: 30px;
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

    td{
        font-size: 25px;
        text-align: center;
    }

    td{
        padding: 10px !important;
    }
</style>
<body>
<div class="contenidor">
    <?php require("menu.php"); ?>
    <div class="llistatReserves">
        <div class="novaReserva">
            <button class="botoreserva" id="reserva" onclick="">CREAR RESERVA</button>
        </div>
        <table>
            <tr style="border-bottom: 2px solid white !important;">
                <td><b>ESTAT</b></td>
                <td><b>PEL·LÍCULA</b></td>
                <td><b>CLIENT</b></td>
                <td><b>DATA INICI</b></td>
                <td><b>DATA FI</b></td>
                <td></td>
            </tr>
            <?php foreach ($resumreserva as $r){ ?>
                <tr id="<?php echo $r[0]; ?>" style="border-top: 1px solid grey;">
                    <td><i class="fa fa-circle" aria-hidden="true" style="color: <?php if ($r[2]>$date) echo "green"; else echo "red"; ?>;"></i></td>
                    <td><?php echo $r[4]; ?></td>
                    <td><?php echo $r[6]; ?></td>
                    <td><?php echo $r[1]; ?></td>
                    <td><?php echo $r[2]; ?></td>
                    <td><i class="fa fa-trash-o deleteReserva cursor" style="cursor: pointer" aria-hidden="true" onclick="deleteElement('<?php echo $r[0]; ?>')"></i></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
<script>
    function deleteElement(id) {
        var FD = new FormData();
        FD.append("idReserva", id);
        Swal.fire({
            icon: 'warning',
            title: 'Eps!',
            text: 'Estas segur que vols esborrar aquesta reserva?',
            showDenyButton: true,
            confirmButtonText: 'Si',
            denyButtonText: 'No',
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    type: "POST",
                    url: "ajaxDeleteReserva.php",
                    data: FD,
                    processData: false,
                    contentType: false,
                    success : function(data){
                       window.location.href = "llistatReserves.php";
                    }
                })
            }
        })
    }

    $(document).ready(function (){
        $(document).on("click", ".botoreserva", function() {
            window.location.href = "insertreserva.php"
        });
    });

</script>
</html>

