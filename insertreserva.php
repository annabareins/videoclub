<?php
    require_once("connect_data.php");

    //PELICULA
    $id = "";
    $copia = "";
    $peliculaSeleccionada = "";
    if (!isset($_POST['_id'])) {
        $id=$_POST['id'];
        $peliculaSeleccionada = $peliculesdb->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        $copiaSeleccionada = $copiesdb->find(['pelicula' => $id, 'estat' => 0]);
        foreach ($copiaSeleccionada as $c) $copia = $c["_id"];
    }
    $pelicula = "";
    $pelicula = $peliculesdb->find();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nova reserva</title>
    <?php require_once("head.php"); ?>
<style>
    .reservaGeneral{
        width: 100%;
        padding: 50px 5%;
        color: white;
        display: flex;
        overflow-y: scroll;
    }

    .seleccioPelicula{
        padding-bottom: 50px;
    }

    .seleccionable:focus-visible{
        border: none;
    }

    option{
        color: black;
    }

    .seleccionable{
        background: none;
        border: none;
        color: white;
        width: 60%;
        font-size: 25px;
    }

    .dadesClient{
        font-size: 30px;
        width: 100%;
    }

    input{
        background: none;
        border: none;
        border-bottom: 2px solid white;
        color: white;
    }

    input:focus-visible{
        outline: none;
    }

    .client, .nomClient, .datesReserves{
        display: flex;
        flex-direction: row;
        padding-top: 20px;
        align-items: center;
    }

    .nomClient{
        padding-top: 0;
    }

    .afegirClient, .estatClient{
        padding: 0 35px;
    }

    .dadesReserva{
        width: 100%;
        padding: 50px 0;
    }

    #dataInici, #dataFi{
        margin-right: 50px;
        margin-left: 20px;
    }

    .pelicula{
        width: 40%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .imatge{
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 25px;
    }

    #peliculaTitol{
        margin: 0;
    }

    .estat{
        font-size: 18px;
    }

    .tarifa{
        display: flex;
        justify-content: space-between;
        font-size: 30px;
        padding-right: 50px;
    }

    #reserva{
        background: #74818E;
        border: none;
        color: white;
        padding: 10px 30px;
        font-size: 25px;
        border-radius: 15px;
    }

    #reserva:hover{
        background: #6B7885;
    }

</style>
<body>
<class class="contenidor">
    <?php require_once("menu.php"); ?>
    <div class="reservaGeneral">
        <div class="reserva">
            <div class="seleccioPelicula">
                <select class="seleccionable" id="pelicula">
                    <option value="">Selecciona la pel·lícula</option>
                    <?php foreach($pelicula as $p) { ?>
                        <option value="<?php echo $p['_id']; ?>" data-id = "<?php echo $p["_id"]; ?>" data-titol="<?php echo $p['titol'];?>" data-imatge="<?php echo $p['imatge'];?>" <?php if($id == $p['_id']) echo "selected";?>><?php echo $p["titol"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="dadesClient">
                <b>Dades client</b>
                <div class="client">
                    <div class="dniClient">
                        <input type="search" id="dni" name="dni" placeholder="DNI">
                    </div>
                    <div class="afegirClient"><i class="fa fa-plus fa-lg" aria-hidden="true"></i></div>
                    <div class="nomClient" style="display: none;" id="nomClient">
                        <b id="client"></b>
                        <div class="estatClient"><i class="fa fa-exclamation-triangle" aria-hidden="true" id="estatClient"></i></div>
                    </div>
                </div>
                <div class="dadesReserva">
                    <b>Dades reserva</b>
                    <div class="datesReserves">
                        <div class="reservaDataInici">
                            Data inici:
                            <input type="date" id="dataInici" name="dataInici">
                        </div>
                        <div class="reservaDataFi">
                            Data fi:
                            <input type="date" id="dataFi" name="dataFi">
                        </div>
                    </div>
                </div>
                <div class="total">
                    <div class="tarifa"></div>
                    <div class="preu"></div>
                </div>
            </div>
            <div class="tarifa" style="display: none" id ="tarifa">
                Tarifa: 5€
                <div class="botoReserva">
                    <button id="reserva">Reserva</button>
                </div>
            </div>
        </div>
        <div class="pelicula">
            <div class="imatge" id ="imatge" style="display: <?php if ($peliculaSeleccionada == "") echo "none"; ?>;"><img id="peliculaImatge" style="width: 400px; height: 100%;" src="<?php if ($peliculaSeleccionada != "") echo $peliculaSeleccionada["imatge"]; ?>"><p id="peliculaTitol"><?php if ($peliculaSeleccionada != "") echo $peliculaSeleccionada["titol"]; ?></p></div>
            <div class="estat" id ="estat" style="display: <?php if ($peliculaSeleccionada == "") echo "none"; ?>; color:<?php if ($copia != ""){ echo "green"; } else echo "red"; ?>;"><b id="peliculaEstat"><?php if ($peliculaSeleccionada != "" && $copia != ""){ echo "DISPONIBLE"; } else echo "OCUPAT"; ?></b></div>
        </div>
    </div>
</class>
</body>
<script type="text/javascript">
    $(document).ready(function() {

        var errorPelicula = <?php if ($copia != "") echo "false"; else echo "true";?>;
        var errorUsuari = true;
        var errorDates = true;

        var client = ""
        var copia = '<?php echo $copia?>';
        var dataIniciDef = "";
        var dataFiDef = "";

        $(".nomClient").hide();

        $(".seleccionable").change(function () {
            if(this.value != ""){
                document.getElementById("imatge").style.display = "flex";
                document.getElementById("estat").style.display = "flex";
                document.getElementById("peliculaEstat").style.display = "block";
                document.getElementById("peliculaImatge").style.display = "block";
                document.getElementById("peliculaTitol").style.display = "block";
                document.getElementById("peliculaEstat").style.display = "block";
                var imatge = $(this).find(':selected').data('imatge');
                document.getElementById("peliculaImatge").src = imatge;
                var titol = $(this).find(':selected').data('titol');
                document.getElementById("peliculaTitol").innerHTML = titol;
                var FD = new FormData();
                FD.append("idPelicula", this.value);
                $.ajax({
                    type: "POST",
                    url: "ajaxFindCopies.php",
                    data: FD,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    success : function(data){
                        if(data.length > 0){
                            copia = data[0]["$oid"];
                            document.getElementById("peliculaEstat").innerHTML = "DISPONIBLE";
                            document.getElementById("peliculaEstat").style.color = "green";
                            errorPelicula = false;
                            showTarifa();
                        }
                        else{
                            copia = "";
                            document.getElementById("peliculaEstat").innerHTML = "OCUPADA";
                            document.getElementById("peliculaEstat").style.color = "red";
                            errorPelicula = true;
                            showTarifa();
                        }
                    }
                })
            }
            else{
                copia = "";
                document.getElementById("peliculaImatge").style.display = "none";
                document.getElementById("peliculaTitol").style.display = "none";
                document.getElementById("peliculaEstat").style.display = "none";
                errorPelicula = true;
                showTarifa();
            }
        });

        $("#dni").keyup(function () {
            errorUsuari = true;
            client = "";
            document.getElementById("nomClient").style.display = "none";
            showTarifa();
            if (this.value.length == 9){
                var dni = this.value;
                $.ajax({
                    url: "ajaxFindUser.php",
                    data: dni,
                    dataType: "json",
                    success : function(data){
                        $(".nomClient").show();
                        if(data[1]){
                            document.getElementById("client").innerHTML = data[1];
                            if (data[3] < 3) {
                                document.getElementById("nomClient").style.display = "flex";
                                document.getElementById("estatClient").style.color = "green";
                                document.getElementById("estatClient").title = "Correcte";
                                errorUsuari = false;
                                client = data[0]["$oid"];
                                showTarifa();
                            }
                            else {
                                document.getElementById("nomClient").style.display = "flex";
                                document.getElementById("estatClient").style.color = "red";
                                document.getElementById("estatClient").title = "Moròs";
                                errorUsuari = true;
                                client = "";
                                showTarifa();
                            }
                        }
                        else{
                            document.getElementById("nomClient").style.display = "flex";
                            document.getElementById("estatClient").style.color = "white";
                            document.getElementById("estatClient").title = "No existeix cap usuari";
                            errorUsuari = true;
                            client = "";
                            showTarifa();
                        }
                    }
                })
            }
            else{
                document.getElementById("client").innerHTML = "";
                errorUsuari = false;
            }
        });

        $("#dataFi").change(function (){
            var dataFi = this.value;
            var dataInici = document.getElementById("dataInici").value;
            if(dataInici && dataFi){
                if (dataFi > dataInici) {
                    errorDates = false;
                    dataIniciDef = dataInici;
                    dataFiDef = dataFi;
                    showTarifa();
                }
                else{
                    errorDates = true;
                    dataIniciDef = "";
                    dataFiDef = "";
                    showTarifa();
                }
            }
            else{
                errorDates = true;
                dataIniciDef = "";
                dataFiDef = "";
                showTarifa();
            }
        });

        $("#dataInici").change(function (){
            var dataInici = this.value;
            var dataFi = document.getElementById("dataFi").value;
            if(dataInici && dataFi){
                if (dataFi > dataInici) {
                    errorDates = false;
                    dataIniciDef = dataInici;
                    dataFiDef = dataFi;
                    showTarifa();
                }
                else{
                    errorDates = true;
                    showTarifa();
                }
            }
            else{
                errorDates = true;
                showTarifa();
            }
        });

        function showTarifa(){
            if (!errorDates && !errorPelicula && !errorUsuari){
                document.getElementById("tarifa").style.display = "flex";
            }
            else{
                document.getElementById("tarifa").style.display = "none";
            }
        }

        $(document).on("click", ".botoReserva", function () {
            var FD = new FormData();
            FD.append("client", client);
            FD.append("copia", copia);
            FD.append("dataInici", dataIniciDef);
            FD.append("dataFi", dataFiDef);
            $.ajax({
                type: "POST",
                url: "ajaxInsertReserva.php",
                data: FD,
                processData: false,
                contentType: false,
                success : function(data){
                    window.location.href = "llistatReserves.php";
                }
            })
        });

    });
</script>
</html>